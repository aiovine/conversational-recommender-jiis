package functions.elicitation;

import functions.EntityService;

public class GiveAdviceVarxPop implements ActLearnInterface {
	EntityService ef = new EntityService();;
	int userID;

	GiveAdviceVarxPop(int userID) {
		this.userID = userID;
	}

	ControlEntity ce = new ControlEntity(userID);

	/**
	 * Returns the entity with the highest index 
	 * sqrt(popularity) * variance
	 * 
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	@Override
	public String GetEntityToRate(int userID) {

		String uri = ef.getEntityToRatePopxVar(userID);
		System.out.println("movieURI_PopxVar: " + uri);

		return uri;
	}
}