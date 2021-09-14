package functions;

import java.util.ArrayList;
import java.util.List;

import configuration.Configuration;
import entity.Entity;
import entity.Pair;
import graph.AdaptiveSelectionController;


public class EntityService {
	
	private AdaptiveSelectionController asController;
	
	public EntityService() {
		this.asController = new AdaptiveSelectionController();
	}
	
	/**
	 * Aggiunge una preferenza per l'utente specificato e per l'entità (film) selezionata
	 * @param userID ID utente
	 * @param entityURI URI dell'entità
	 * @param rating Preferenza (0: dislike, 1: like, 2: skip)
	 * @return
	 */
	public boolean addEntityPreference(int userID, String entityURI, int rating, String lastChange) {
		boolean success = false;
		System.out.println("DEBUG entityURI: " + entityURI);
		if (!entityURI.equalsIgnoreCase("null")) {
			try {
				asController.putEntityRatedByUser(userID, entityURI, rating, lastChange);
				success = true;
			} catch (Exception e) {
				e.printStackTrace();
			}
			if (rating == 1 || rating == 2 ) {
				try {
					asController.putLastChange(userID, "entity_rating");
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		}
		else {
			System.err.println("Error - addEntityPreference userID: " + userID + " entityURI:" + entityURI);
		}		
		
		return success;		
	}
	
	/**
	 * Salta la valutazione per il film corrente
	 */
	public void skipRecommendedEntity(int userID, String entityURI) {	
		try {
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			asController.insertLikeRecEntityRatingByUser(userID, entityURI, numberRecommendationList, 0);
			asController.insertDislikeRecEntityRatingByUser(userID, entityURI, numberRecommendationList, 0);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Aggiunge la valutazione dell'utente per un'entità raccomandata dal sistema
	 * @return
	 */
	public boolean addRecommendedEntityPreference(int userID, String entityURI, int rating, String lastChange) {
		boolean success = false;

		try {
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			
			//Aggiungo il film raccomandato tra quelli valutati dall'utente
			if (rating == 1) {
				asController.insertLikeRecEntityRatingByUser(userID, entityURI, numberRecommendationList, 1);
			} else {
				asController.insertDislikeRecEntityRatingByUser(userID, entityURI, numberRecommendationList, 1);
			}
			asController.putLastChange(userID, "entity_rating");

			//Aggiungo la preferenza sul film
			asController.putEntityRatedByUser(userID, entityURI, rating, lastChange);

		} catch (Exception e) {
			e.printStackTrace();
		}
		
		return success;
	}
	
	public void setRefine(int userID, String entityURI) {
		try {
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			asController.insertRefineRecEntityRatingByUser(userID, entityURI, numberRecommendationList, "refine");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void setWhy(int userID, String entityURI) {
		try {
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			asController.insertWhyRecEntityRequestByUser(userID, entityURI, numberRecommendationList, "why");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void setDetails(int userID, String entityURI) {
		try {
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			asController.insertDetailsRecEntityRequestByUser(userID, entityURI, numberRecommendationList, "details");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/**
	 * Elimina tutte le entità valutate dall'utente specificato
	 */
	public boolean deleteAllRatedEntities(int userID) {
		int oldNumberRatedEntities;
		try {
			oldNumberRatedEntities = asController.getNumberRatedEntities(userID);
			
			asController.deleteAllEntityRatedByUser(userID);
			int numberRatedEntities = asController.getNumberRatedEntities(userID);
			
			if (numberRatedEntities == 0 || numberRatedEntities < oldNumberRatedEntities ) {			
				return true;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		return false;
	}
	
	public String[] getEntityToControl(int userID) {
		try {
			return asController.getEntityControlling(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	public String[] getEntitySkipped(int userID) {
		try {
			return asController.getEntitySkipping(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	public double getEntityMovieLens(String label) {
		try {
			return asController.getEntityFromMovieLens(label);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return 0.0;
	}

	/**
	 * Returns the most rated movie in the MovieLen DB not yet rated by the user
	 *  
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	public String getEntityToRatingByPopularEntities(int userID) {
		try {
			return asController.getEntityToRatingByPopularEntities(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	public String getEntityToRateJaccard(int userID) {
		try {
			return asController.getEntityToRatingByPopularEntitiesOrJaccard(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	/**
	 * 50% chance to return a random entity and
	 * 50% chance to return a popular entity to recommend
	 * 
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	public String getEntityToRateRandPopular(int userID) {
		try {
			return asController.getEntityToRatingByRandomPopularEntities(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	/**
	 * Returns the entity with the highest index 
	 * sqrt(popularity) * variance
	 * 
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	public String getEntityToRatePopxVar(int userID) {
		try {
			return asController.getEntityToRatingByPopxVar(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	public String getEntityToRateHighestPrediction(int userID) {
		try {
			return asController.getEntityToRatingByPopularEntitiesOrHighestPrediction(userID);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}
	
	/**
	 * Restituisce la lista di entità raccomandate ottenuta da un pagerank precedente, oppure null
	 * se non è stato effettauto alcun pagerank
	 */
	public List<String> getCachedRecommendedEntities(int userID) {
		List<String> recommended = new ArrayList<String>();
		List<Pair<Double, String>> recPairs = asController.getEntitiesToRecommend(userID);
		for (Pair<Double, String> pair: recPairs) {
			recommended.add(pair.value);
		}
		//recommended = new ArrayList<String>(asController.getPropertyValueListMapFromPropertyType(userID, "movie").values());
		return recommended;
	}
	
	
	/**
	 * Inserisce nella tabella ratings_rec_movies l'entità correntemente proposta all'utente
	 */
	public void insertEntityToRate(int userID, String entityURI, int index) {
		try {
			int pagerankCicle = asController.getNumberPagerankCicle(userID);
			int numberRecommendationList = asController.getNumberRecommendationList(userID);
			asController.insertRecEntityToRatingByUser(userID, 
					entityURI, 
					numberRecommendationList,
					index, 
					pagerankCicle, 
					"movierecsysbot", 
					"0", //TODO: Aggiungere messageID?
					0);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Estrae tutte le proprietà per un'entità e le inserisce in un oggetto JSON
	 * @param entityURI
	 * @return
	 */
	public Entity getEntityDetails(String entityURI) {
		Configuration configuration = Configuration.getDefaultConfiguration();
		Entity entity = null;
		try {
			List<List<String>> properties = asController.getAllEntityProperties(entityURI, configuration.getPropertyTypes());
			entity = new Entity(properties, configuration.getPropertyTypesDetails());
		} catch (Exception e) {
			e.printStackTrace();
		}
		return entity;
	}
	
	public String getEntityLabel(String uri) {
		return asController.getEntityLabel(uri);
	}
	
	public String getEntityMLLabel(String uri) {
		return asController.getEntityMLLabel(uri);
	}
	
	public String getEntityMLURI(String uri) {
		return asController.getEntityLabel(uri);
	}
	
	public String getEntityURI(String label) {
		return asController.getEntityURI(label);
	}
	
	public boolean isEntity(String uri) {
		return asController.getEntityLabel(uri) != null;
	}
}
