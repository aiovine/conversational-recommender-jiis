package test;

public class PropertyRating {
	private int userID;
	private String propertyTypeURI;
	private String propertyURI;
	private int rating;
	private long ratedAt;
	private String lastChange;
	private int numberRecommendationList;
	private String botName;
	public PropertyRating(int userID, String propertyTypeURI, String propertyURI, int rating, long ratedAt,
			String lastChange, int numberRecommendationList, String botName) {
		super();
		this.userID = userID;
		this.propertyTypeURI = propertyTypeURI;
		this.propertyURI = propertyURI;
		this.rating = rating;
		this.ratedAt = ratedAt;
		this.lastChange = lastChange;
		this.numberRecommendationList = numberRecommendationList;
		this.botName = botName;
	}
	public int getUserID() {
		return userID;
	}
	public String getPropertyTypeURI() {
		return propertyTypeURI;
	}
	public String getPropertyURI() {
		return propertyURI;
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
	
}
