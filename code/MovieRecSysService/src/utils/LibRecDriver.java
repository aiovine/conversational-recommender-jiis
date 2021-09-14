package utils;

import java.io.File;
import java.nio.file.Files;
import java.nio.file.StandardOpenOption;
import java.util.Collections;
import java.util.Comparator;
import java.util.LinkedList;
import java.util.List;
import java.util.Set;
import com.google.common.collect.BiMap;

import database.AccessRecsysDB;
import entity.Pair;
import net.librec.conf.Configuration;
import net.librec.recommender.RecommenderContext;
import net.librec.similarity.CosineSimilarity;
import net.librec.similarity.RecommenderSimilarity;

public class LibRecDriver {
	private static final String DUMMY_ID = "UID";

	private int user_id;
	private AccessRecsysDB dbAccess;

	public LibRecDriver(int user_id) {
		super();
		this.user_id = user_id;
		this.dbAccess = new AccessRecsysDB();
	}

	public String getHighestPredictedRatingURI() throws Exception {

		File dataset = getDatasetFile();
		Configuration conf = LibRecDriver.getConfiguration(dataset);

		// BUILD DATA MODEL
		TextDataModel dataModel = new TextDataModel(conf);
		dataModel.buildDataModel();

		// BUILD SIMILARITY
		RecommenderSimilarity similarity = new CosineSimilarity();
		similarity.buildSimilarityMatrix(dataModel);

		// BUILD RECOMMENDER CONTEXT
		RecommenderContext context = new RecommenderContext(conf, dataModel, similarity);

		// BUILD RECOMMENDER
		SVDPlusPlusRecommender recommender = new SVDPlusPlusRecommender();
		recommender.setContext(context);
		recommender.train(context);

		List<Pair<String, Double>> uriAndRatingList = getRatingPredictions(dataModel, recommender);
		String movieURI = getHighestRated(uriAndRatingList);
		
		dataset.delete();

		return movieURI;
	}

	private File getDatasetFile() throws Exception {
		List<String> ratings = dbAccess.getAllRatingsForLibRec(user_id, DUMMY_ID);
		File tempFile = File.createTempFile("tmpRatings" + user_id, ".txt");
		Files.write(tempFile.toPath(), ratings, StandardOpenOption.WRITE);

		return tempFile;
	}

	private static Configuration getConfiguration(File dataset) {

		// LIBREC CONFIGURATION
		// Info: https://github.com/guoguibing/librec/tree/3.0.0/doc/E-wiki
		Configuration conf = new Configuration();

		String fileName = dataset.getName();
		String filePath = dataset.getAbsolutePath().replace(fileName, "");

		// System configuration
		conf.set("rec.recommender.verbose", "true");
		conf.set("dfs.log.dir", "log");
		conf.set("dfs.result.dir", "result");

		// Convertor
		conf.set("dfs.data.dir", filePath);
		conf.set("data.input.path", fileName);
		conf.set("data.column.format", "UIR");
		conf.set("data.convert.binarize.threshold", "-1.0");
		conf.set("data.model.format", "text");

		// Splitter
		conf.set("data.model.splitter", "ratio");
		conf.set("data.splitter.ratio", "rating");
		conf.set("data.splitter.trainset.ratio", "0.9");

		// Similarity configuration
		conf.set("rec.recommender.similarity.key", "user");

		// SVD++ configuration
		conf.set("rec.recommender.isranking", "false");
		conf.set("rec.iterator.learnrate", "0.002");
		conf.set("rec.iterator.learnrate.maximum", "0.05");
		conf.set("rec.iterator.maximum", "100");
		conf.set("rec.user.regularization", "0.01");
		conf.set("rec.item.regularization", "0.01");
		conf.set("rec.impItem.regularization", "0.01");
		conf.set("rec.bias.regularization", "0.01");
		conf.set("rec.factor.number", "20");
		conf.set("rec.learnrate.bolddriver", "false");
		conf.set("rec.learnrate.decay", "1.0");

		return conf;
	}

	private List<Pair<String, Double>> getRatingPredictions(TextDataModel dataModel, SVDPlusPlusRecommender recommender) throws Exception {

		int userIndex = dataModel.getUserMappingData().get(DUMMY_ID);

		BiMap<String, Integer> entityURIsMap = dataModel.getItemMappingData();
		Set<String> ratedEntity = dbAccess.selectRatedMovieByUser(user_id);

		for (String uri : ratedEntity)
			entityURIsMap.remove(uri);

		List<Pair<String, Double>> uriAndRatingList = new LinkedList<>();

		for (String uri : entityURIsMap.keySet()) {
			int entityIndex = entityURIsMap.get(uri);
			uriAndRatingList.add(new Pair<>(uri, recommender.predict(userIndex, entityIndex)));
		}

		return uriAndRatingList;
	}

	private String getHighestRated(List<Pair<String, Double>> uriAndRatingList) {

		Collections.sort(uriAndRatingList, new Comparator<Pair<String, Double>>() {
			@Override
			public int compare(Pair<String, Double> o1, Pair<String, Double> o2) {
				return o2.value.compareTo(o1.value);
			}
		});

		return uriAndRatingList.get(0).key;
	}

	public static void main(String[] args) throws Exception {
		LibRecDriver lrd = new LibRecDriver(1234);
		String movieURI = lrd.getHighestPredictedRatingURI();
		
		System.out.println(">> " + movieURI + " <<");
		System.out.println("END");
	}

}
