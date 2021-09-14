package dialog.handler.actions;

import com.google.cloud.dialogflow.v2.QueryResult;

import dialog.ApiAiResponse;
import dialog.DialogState;
import dialog.ItemSuggestion;
import dialog.Preference;
import dialog.functions.SetItemToRateFunction;
import dialog.handler.DefaultHandlerResponse;
import dialog.handler.DialogHandler;
import dialog.handler.HandlerResponse;
import exception.NoItemsToSuggestException;
import functions.EntityService;
import functions.ResponseService;
import functions.ServiceSingleton;

/**
 * Handles the dialog when the user decides to skip a disambiguation, or a rating of
 * a recommended item.
 * If a disambiguation is skipped, it is ignored.
 * If a recommendation is skipped, we proceed to the next one.
 * Returns a feedback message for the skip.
 * @author Andrea Iovine
 *
 */
public class SkipHandler implements DialogHandler {

	@Override
	public boolean check(int userID, QueryResult result, DialogState state, String messageID) {
		String intentName = result.getIntent().getDisplayName();
		return intentName.equals("request_recommendation - skip")
				|| intentName.equals("skip"); 
	}

	@Override
	public HandlerResponse handle(int userID, QueryResult result, DialogState state, String messageID) {
		ResponseService responseService = ServiceSingleton.getResponseService();
		ApiAiResponse response = new ApiAiResponse();
		Preference p = state.getPendingPreferenceQueue().peek();
		boolean success = false;
		EntityService es = ServiceSingleton.getEntityService();
				
		//Check if there is a pending prompt
		if (p != null && !p.allDisambiguated()) {
			success = true;
			//Skip the prompt
			p.skipCurrentDisambiguation();
			response.addSpeech(responseService.getSkipMessage(success));
			response.setSkippedDisambiguation(true);
			if (state.getCurrentRecommendedIndex() > -1) {
				response.addContext("request_recommendation-critiquing-followup");
			} else {
				response.addContext("preference-followup");
			}
			response.addEvent("preference");
		} else if (state.getCurrentRecommendedIndex() > -1) {
			es.skipRecommendedEntity(
					userID,
					es.getCachedRecommendedEntities(userID).get(state.getCurrentRecommendedIndex())
					);
			success = true;
			response.addSpeech(responseService.getSkipMessage(success));
			response.addEvent("recommendation");
		} else if (state.getCurrentSuggestion() != null) {
			ItemSuggestion currentSuggestedItem = state.getCurrentSuggestion();
			es.addEntityPreference(userID, currentSuggestedItem.getID(), 2, "user");
			success = true;
			response.addSpeech(responseService.getSkipMessage(success));
		} else {
			response.addSpeech(responseService.getSkipMessage(success));
		}
		
		//Try to set the next suggestion
		SetItemToRateFunction suggestion = new SetItemToRateFunction();
		try {
			suggestion.setItemToRate(userID, state, false);
		} catch (NoItemsToSuggestException e) {
			//No more items to suggest, do nothing
		}
		
		return new DefaultHandlerResponse(response, true, true);
	}

}
