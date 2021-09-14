package restService;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;

import javax.servlet.ServletContext;
//import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
//import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;

import com.google.gson.Gson;

import functions.EntityService;
import graph.AdaptiveSelectionController;

@Path("/userDetailsEntityRequest")
public class PutDetailsEntityRequest {
	
	//Tomcat non permette la put, ci sara' un modo per configurarlo attraverso web.xml
	//ma per il momento la camuffiamo in get
	@Context ServletContext servletContext;
	@GET
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/putDetailsEntityRequest")
	public String putDetailsEntityRequest(@QueryParam("userID") String userID,
								   	 @QueryParam("entityURI") String entityURI,
								   	 @QueryParam("numberRecommendationList") String numberRecommendationList,
								   	 @QueryParam("details") String details
								   	 ) throws Exception 
	{
		String entityName = entityURI.replace("http://dbpedia.org/resource/", "")
				.replace("_", " ");
		if (entityName.contains("(")) {
			entityName = entityName.substring(0, entityName.indexOf("(") - 1);
		}
		System.out.println("debug");
		int user_id = Integer.parseInt(userID);
		int number_recommendation_list = Integer.parseInt(numberRecommendationList);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();

		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		System.out.println("debug");

		EntityService service = new EntityService();
		String entityObjectUri = service.getEntityURI(entityName);
		
		int numberRatedEntities;

		if (!entityURI.equalsIgnoreCase("null")) {
			asController.insertDetailsEntityRequestByUser(user_id, entityObjectUri, number_recommendation_list, details);
//			asController.putLastChange(user_id, "details");
		}
		else {
			System.err.println("/putDetailsEntityRequest/Error - insertDetailsEntityRequestByUser userID: " + user_id + " entityObjectUri:" + entityObjectUri);
		}	
		System.out.println("debug");

		numberRatedEntities = asController.getNumberRatedEntities(user_id);		
		Gson gson = new Gson();
		String json = gson.toJson(numberRatedEntities);
		System.out.println("debug");

		System.out.print("/putDetailsEntityRequest/userID: " + user_id + " entityObjectUri:" + entityObjectUri + " numberRecommendationList:" + numberRecommendationList + "/");
		System.out.println(json);
		
		return json;		
	}	
}







