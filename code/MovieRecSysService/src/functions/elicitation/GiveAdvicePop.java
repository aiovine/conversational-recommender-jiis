package functions.elicitation;

import functions.EntityService;

public class GiveAdvicePop implements ActLearnInterface {
	EntityService ef = new EntityService();
	int userID;

	GiveAdvicePop(int userID) {
		this.userID = userID;
	}

	ControlEntity ce = new ControlEntity(userID);

	/**
	 * Returns the most rated entity in the MovieLen DB not yet rated by the user
	 *  
	 * @param  userID 	user identifier
	 * @return String 	uri of the entity
	 */
	@Override
	public String GetEntityToRate(int userID) {
		
		String uri = ef.getEntityToRatingByPopularEntities(userID);
		System.out.println("movieURI_Pop: " + uri);
					
		return uri;
	}
}
