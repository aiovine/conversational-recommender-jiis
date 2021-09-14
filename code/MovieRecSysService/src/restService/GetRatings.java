package restService;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;

import com.google.gson.Gson;

import graph.AdaptiveSelectionController;

@Path("/getRatings")
public class GetRatings {
		
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("/getAllEntityOrPropertyRatings")
	public String getAllEntityOrPropertyRatings (@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		Map<String, Integer> entityOrPropertyToRatingMap = new HashMap<String, Integer>();
		entityOrPropertyToRatingMap = asController.getPosNegRatingForUserFromRatings(user_id);
		System.out.println("entityOrPropertyToRatingMap: " + entityOrPropertyToRatingMap);
		Gson gson = new Gson();
		String json = gson.toJson("null");

		if (entityOrPropertyToRatingMap != null && !entityOrPropertyToRatingMap.isEmpty()) {			
	  		json = gson.toJson(entityOrPropertyToRatingMap);
		}
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
  		System.out.print("/ratings/getAllEntityOrPropertyRatings/");
  		System.out.println(json);
  		
  		return json;
  	}
	
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("/getPropertyRating")
	public String getPropertyRating (@QueryParam("userID") String userID,
								  	@QueryParam("propertyTypeUri") String propertyTypeUri,
								  	@QueryParam("propertyUri") String propertyUri,
								  	@QueryParam("lastChange") String lastChange) throws Exception 
	{
		int user_id = Integer.parseInt(userID);	

		Map<String,String> userPropertyRatingMap = new HashMap<String, String>();
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		userPropertyRatingMap = asController.getPropertyRatingByUserAndProperty(user_id, propertyTypeUri, propertyUri, lastChange);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		
		if (userPropertyRatingMap != null && !userPropertyRatingMap.isEmpty()) {			
	  		json = gson.toJson(userPropertyRatingMap);
		}
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		 		
  		System.out.print("/propertiesRating/getPropertyRating/userID=" + user_id + "/");
  		System.out.println(json);
	 
  		return json;
	}

	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("/getEntityToRate")
	public String getEntityToRating (@QueryParam("userID") String userID) throws Exception 
	{
		String entityURI = "null";
		int user_id = Integer.parseInt(userID);		
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		entityURI = asController.getEntityToRatingByPopularEntities(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (!entityURI.equals("null")) {			
			json = gson.toJson(entityURI);
		}
		 		
		System.out.print("/getEntityToRate/");
		System.out.println(json);
	
		return json;
	}

	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("/getEntityToRateByDiversity")
	public String getEntityToRatingByDiversity (@QueryParam("userID") String userID) throws Exception 
	{
		String entityURI = "null";
		int user_id = Integer.parseInt(userID);		
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		entityURI = asController.getEntityToRatingByPopularEntitiesOrJaccard(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (entityURI != null && !entityURI.isEmpty()) {			
			json = gson.toJson(entityURI);
		}
		 		
		System.out.print("/getEntityToRateByDiversity/");
		System.out.println(json);
	
		return json;
	}
	
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("/getEntitiesToRateFromJaccardDistanceMap")
	public String getEntitiesToRatingFromJaccardDistanceMap (@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		Map<String, Double> entitiesJaccardDistanceMap = new HashMap<String, Double>();
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		entitiesJaccardDistanceMap = asController.getEntitiesToRatingFromJaccardDistanceMapByUser(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		
		if (entitiesJaccardDistanceMap != null && !entitiesJaccardDistanceMap.isEmpty()) {			
	  		json = gson.toJson(entitiesJaccardDistanceMap);
		}
		
  		System.out.print("/ratings/getEntitiesToRatingFromJaccardDistanceMap/");
  		System.out.println(json);
  		
  		return json;
  		
	}
	
	@GET
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/getNumberRatedEntities")
	public String getNumberRatedEntities (@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		int numberRatedEntities = asController.getNumberRatedEntities(user_id);
	
		Gson gson = new Gson();
		String json = gson.toJson(numberRatedEntities);
		 
		System.out.print("/numbers/getNumberRatedEntities/");
		System.out.println(json);
		
		return json;		
	}
	
	@GET
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/getNumberRatedProperties")
	public String getNumberRatedProperties (@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		int numberRatedProperties = asController.getNumberRatedProperties(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson(numberRatedProperties);
		 
		System.out.print("/numbers/getNumberRatedProperties/");
		System.out.println(json);
		
		return json;		
	}
	
	@GET
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/getNumberRatedRecEntityList")
	public String getNumberRatedRecEntityList (@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		int numberRatedRecEntity = asController.getNumberRatedRecEntityByUserAndRecList(user_id);
	
		Gson gson = new Gson();
		String json = gson.toJson(numberRatedRecEntity);
		 
		System.out.print("/numbers/getNumberRatedRecEntityList/");
		System.out.println(json);
		
		return json;		
	}
}
