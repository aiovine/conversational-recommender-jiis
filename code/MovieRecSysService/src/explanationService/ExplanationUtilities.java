package explanationService;

import configuration.Configuration;
import functions.EntityService;
import graph.AdaptiveSelectionController;

public final class ExplanationUtilities {

	private ExplanationUtilities() {
		// Cannot instantiate
	}
	
	protected static String getExplanation(String userID, String entityURI) {
		
		EntityService es = new EntityService();
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		String explanationString = "Sorry, I couldn't find any reason for the suggestion.";
        String[] propertyTypes = Configuration.getDefaultConfiguration().getPropertyTypesForExplanation();
		try {
			String explanationEntity = asController.getEntityExplanationByUserEntity(Integer.parseInt(userID), entityURI, propertyTypes);
			String explanationLikeProperty = asController.getEntityExplanationByLikeUserProperty(Integer.parseInt(userID), entityURI, propertyTypes);
	        String explanationDislikeProperty = asController.getEntityExplanationByDislikeUserProperty(Integer.parseInt(userID), entityURI, propertyTypes);

	     
	        if (explanationEntity != null && !explanationEntity.isEmpty()) {
				if (explanationLikeProperty != null && !explanationLikeProperty.isEmpty()) {
					explanationString = explanationEntity + ".\nAnd " + explanationLikeProperty;
				}
				else {
					explanationString = explanationEntity;
				}
			}
			else if (explanationLikeProperty != null && !explanationLikeProperty.isEmpty()) {			
				explanationString = explanationLikeProperty;
			}
			else if (explanationDislikeProperty != null && !explanationDislikeProperty.isEmpty()){
				explanationString = explanationDislikeProperty;			
			}

		} catch (Exception e) {
			e.printStackTrace();
		}
        
		return explanationString;
	}
}
