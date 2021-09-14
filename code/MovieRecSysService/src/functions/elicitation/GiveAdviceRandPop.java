package functions.elicitation;

import functions.EntityService;

public class GiveAdviceRandPop implements ActLearnInterface {
	EntityService ef = new EntityService();;
	int userID;

	GiveAdviceRandPop(int userID) {
		this.userID = userID;
	}

	ControlEntity ce = new ControlEntity(userID);

	/**
	 * 50% chance to return a random entity and
	 * 50% chance to return a popular entity to recommend
	 * 
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	@Override
	public String GetEntityToRate(int userID) {

		String uri = ef.getEntityToRateRandPopular(userID);
		System.out.println("movieURI_RandPop: " + uri);

		return uri;
	}
}
