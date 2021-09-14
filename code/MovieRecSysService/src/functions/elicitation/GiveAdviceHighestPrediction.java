package functions.elicitation;

import functions.EntityService;

public class GiveAdviceHighestPrediction implements ActLearnInterface{
	EntityService ef=new EntityService();
	int userID;
	GiveAdviceHighestPrediction(int userID){
		this.userID = userID;
	}
	ControlEntity ce=new ControlEntity(userID);
	/**
	 * Returns the highest prediction entity from a cf recommender system from an to recommend
	 * @param int userID user identifier
	 * @return	String ID entity to recommend
	 */
	@Override
	public String GetEntityToRate(int userID) {

		String uri = ef.getEntityToRateHighestPrediction(userID);
		return uri;
	}
}

