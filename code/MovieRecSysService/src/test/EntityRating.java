package test;

public class EntityRating {
	private int userID;
	private String entityURI;
	private int rating;
	private long ratedAt;
	private String lastChange;
	private int numberRecommendationList;
	private String details;
	private String botName;
	public EntityRating(int userID, String entityURI, int rating, long ratedAt,
			String lastChange, int numberRecommendationList, String details, String botName) {
		super();
		this.userID = userID;
		this.rating = rating;
		this.ratedAt = ratedAt;
		this.lastChange = lastChange;
		this.numberRecommendationList = numberRecommendationList;
		this.details = details;
		this.botName = botName;
		this.entityURI = entityURI;
	}
	public int getUserID() {
		return userID;
	}
	public String getEntityURI() {
		return entityURI;
	}
	public int getRating() {
		return rating;
	}
	public long getRatedAt() {
		return ratedAt;
	}
	public String getLastChange() {
		return lastChange;
	}
	public int getNumberRecommendationList() {
		return numberRecommendationList;
	}
	public String getBotName() {
		return botName;
	}
	public String getDetails() {
		return details;
	}
	
}
