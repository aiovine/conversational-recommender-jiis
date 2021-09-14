package functions;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;

import configuration.Configuration;
import dialog.FilteredAlias;
import graph.AdaptiveSelectionController;
import test.RecEntityRating;
import utils.Alias;

public class ProfileService {
	
	/**
	 * Elimina l'intero profilo dell'utente specificato
	 */
	public boolean deleteUserProfile(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		int oldNumberPagerankCicle;
		try {
			oldNumberPagerankCicle = asController.getNumberPagerankCicle(userID);
			asController.deleteAllProfileByUser(userID);
			int numberPagerankCicle = asController.getNumberPagerankCicle(userID);
			
			if (numberPagerankCicle == 0 || numberPagerankCicle < oldNumberPagerankCicle ) {			
				return true;
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return false;
	}
	
	/**
	 * Controlla le condizioni affinchè il questionario debba essere somministrato.
	 * Il questionario sarà somministrato alla fine di una sessione di raccomandazione se l'utente
	 * non ha effettuato critiquing, o altrimenti alla fine del secondo ciclo di raccomandazione.
	 * Restituisce true se il questionario deve essere somministrato
	 * @param userID
	 * @return
	 */
	public boolean checkQuestionnaireConditions(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		boolean refineInCurrentCycle = false;
		boolean refineInPreviousCycle = false;
//		try {
//			int numRecList = asController.getNumberRecommendationList(userID);
//			List<RecEntityRating> currentRatings = asController.getRecEntityRatings(userID, numRecList);
//			for (RecEntityRating rating: currentRatings) {
//				if (rating.isRefine() && !refineInCurrentCycle) {
//					refineInCurrentCycle = true;				
//				}
//			}
//			if (numRecList > 0) {
//				List<RecEntityRating> previousRatings = asController.getRecEntityRatings(userID, numRecList - 1);
//				for (RecEntityRating rating: previousRatings) {
//					if (rating.isRefine() && !refineInPreviousCycle) {
//						refineInPreviousCycle = true;
//					}
//				}
//			}
//			
//			//Somministro il questionario se non c'è critiquing nella sessione corrente, o se c'è sia nella corrente che nella precedente
//			return (!refineInCurrentCycle || (refineInCurrentCycle && refineInPreviousCycle));
//		} catch (Exception e) {
//			// TODO Auto-generated catch block
//			e.printStackTrace();
//		}
		return true;
	}
	
	public boolean hasPositiveRating(int userID) {
		boolean hasPositiveRating = false;
		JsonArray profile = this.getUserProfile(userID);
		for (Iterator<JsonElement> iterator = profile.iterator(); iterator.hasNext();) {
			JsonElement element = iterator.next();
			if (element.getAsJsonObject().get("rating").getAsInt() == 1) {
				hasPositiveRating = true;
			}
		}
		return hasPositiveRating;
	}
	
	public JsonArray getUserProfileWithSkips(int userID) {
		Configuration c = Configuration.getDefaultConfiguration();
		EntityService es = new EntityService();
		PropertyService ps = new PropertyService();
		JsonArray result = new JsonArray();
		try {
			AdaptiveSelectionController asController = new AdaptiveSelectionController();
			Map<String, Integer> entityOrPropertyToRatingMap = new HashMap<String, Integer>();
			entityOrPropertyToRatingMap = asController.getRatingsForUserFromRatings(userID);
			for (String key: entityOrPropertyToRatingMap.keySet()) {
				String type;
				JsonObject ratingJson = new JsonObject();
				if (key.startsWith("entity")) {
					type = "entity";
					ratingJson.addProperty("name", key.split(",")[1]);
					ratingJson.addProperty("label", es.getEntityLabel( key.split(",")[1]));
				} else {
					String[] keySplit = key.split(",");
					type = keySplit[0];
					ratingJson.addProperty("name", keySplit[1]);
					ratingJson.addProperty("label", ps.getPropertyLabel(keySplit[1]));
					ratingJson.addProperty("typeLabel", c.getPropertyTypesLabels().get(type));
				}
				ratingJson.addProperty("type", type);
				ratingJson.addProperty("rating", entityOrPropertyToRatingMap.get(key));
				result.add(ratingJson);
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return result;
	}
	
	public JsonArray getUserProfile(int userID) {
		Configuration c = Configuration.getDefaultConfiguration();
		EntityService es = new EntityService();
		PropertyService ps = new PropertyService();
		JsonArray result = new JsonArray();
		try {
			AdaptiveSelectionController asController = new AdaptiveSelectionController();
			Map<String, Integer> entityOrPropertyToRatingMap = new HashMap<String, Integer>();
			entityOrPropertyToRatingMap = asController.getPosNegRatingForUserFromRatings(userID);
			for (String key: entityOrPropertyToRatingMap.keySet()) {
				String type;
				JsonObject ratingJson = new JsonObject();
				if (key.startsWith("entity")) {
					type = "entity";
					ratingJson.addProperty("name", key.split(",")[1]);
					ratingJson.addProperty("label", es.getEntityLabel( key.split(",")[1]));
				} else {
					String[] keySplit = key.split(",");
					type = keySplit[0];
					ratingJson.addProperty("name", keySplit[1]);
					ratingJson.addProperty("label", ps.getPropertyLabel(keySplit[1]));
					ratingJson.addProperty("typeLabel", c.getPropertyTypesLabels().get(type));
				}
				ratingJson.addProperty("type", type);
				ratingJson.addProperty("rating", entityOrPropertyToRatingMap.get(key));
				result.add(ratingJson);
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return result;
	}
	
	public void deletePreference(int userID, String uri) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		try {
			asController.deletePropertyRatedByUser(userID, uri);
			asController.deleteEntityRatedByUser(userID, uri);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/**
	 * Filtra la lista degli alias selezionando solo quelli che si riferiscono a entità
	 * o proprietà valutate dall'utente
	 * @param aliases
	 * @return
	 */
	public List<FilteredAlias> filterAliasesByUserProfile(int userID, List<FilteredAlias> aliases) {
		List<FilteredAlias> filteredAliases = new ArrayList<>();
		JsonArray userProfile = getUserProfile(userID);
		
		//Prendi tutte le preferenze dell'utente
		List<Alias> profileElems = new ArrayList<>();
		for (int i = 0; i < userProfile.size(); i++) {
			JsonObject elem = userProfile.get(i).getAsJsonObject();
			String uri = elem.get("name").getAsString();
			String label = elem.get("label").getAsString();
			profileElems.add(new Alias(uri, label));
		}
		
		//Aggiungi solo gli alias che sono contenuti anche nel profilo utente
		for (FilteredAlias a: aliases) {
			if (profileElems.contains(a.getAlias())) {
				filteredAliases.add(a);
			}
		}
		
		return filteredAliases;
	}
	
	public int getPreferencesCount(int userID) {
		Configuration c = Configuration.getDefaultConfiguration();
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		try {
			if (c.isPropertyTypeDisambiguationEnabled()) {
				return asController.getNumberRatedEntities(userID) + asController.getNumberRatedProperties(userID);
			} else {
				return asController.getNumberRatedEntities(userID) + asController.getNumberRatedPropertiesWithoutDuplicates(userID);
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return -1;
	}
	
	public int getNumRatedRecommendedEntities(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		try {
			return asController.getNumberRatedRecEntityByUserAndRecList(userID);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return 0;
	}
	
	public void doRefocus(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();

		//se il numero di film raccomandati valutati è zero puoi avviare il refocus
		try {
			asController.setRefocusRecListByUser(userID);
			asController.putLastChange(userID, "entity_rating");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public int getPagerankCycle(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		try {
			return asController.getNumberPagerankCicle(userID);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return -1;
	}
	
	public int getNumberRecommendationList(int userID) {
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		try {
			return asController.getNumberRecommendationList(userID);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return -1;
	}
	
	public static void main(String[] args) {
		System.out.println(new ProfileService().getUserProfile(0));
	}
}
