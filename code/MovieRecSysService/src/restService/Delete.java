package restService;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;

import javax.servlet.ServletContext;
import javax.ws.rs.DELETE;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;

import com.google.gson.Gson;

import graph.AdaptiveSelectionController;

@Path("/delete")
public class Delete {
	@Context ServletContext servletContext;
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllPropertyRated")
	public String deleteAllPropertyRated(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		int oldNumberRatedProperties = asController.getNumberRatedProperties(user_id);
		
		asController.deleteAllPropertyRatedByUser(user_id);
		int numberRatedProperties = asController.getNumberRatedProperties(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (numberRatedProperties < oldNumberRatedProperties ) {			
			json = gson.toJson(numberRatedProperties);
		}
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		System.out.println("oldNumberRatedProperties: " + oldNumberRatedProperties);
		System.out.println("numberRatedProperties: " + numberRatedProperties);
		System.out.print("/delete/deleteAllPropertyRated/");
		System.out.println(json);
		
		return json;
		
	}
	
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllEntityRated")
	public String deleteAllEntityRated(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		int oldNumberRatedEntities = asController.getNumberRatedEntities(user_id);

		asController.deleteAllEntityRatedByUser(user_id);
		int numberRatedEntities = asController.getNumberRatedEntities(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (numberRatedEntities < oldNumberRatedEntities ) {			
			json = gson.toJson(numberRatedEntities);
		}
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		System.out.println("oldNumberRatedEntities: " + oldNumberRatedEntities);
		System.out.println("numberRatedEntities: " + numberRatedEntities);
		System.out.print("/delete/deleteAllEntityRated/");
		System.out.println(json);
		
		return json;		
	}
	
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllChatMessage")
	public String deleteAllChatMessage(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		int oldNumberPagerankCicle = asController.getNumberPagerankCicle(user_id);

		asController.deleteAllChatMessageByUser(user_id);
		int numberPagerankCicle = asController.getNumberPagerankCicle(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (numberPagerankCicle < oldNumberPagerankCicle ) {			
			json = gson.toJson(numberPagerankCicle);
		}
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		System.out.println("oldNumberPagerankCicle: " + oldNumberPagerankCicle);
		System.out.println("numberPagerankCicle: " + numberPagerankCicle);
		System.out.print("/delete/deleteAllChatMessage/");
		System.out.println(json);
		
		return json;		
	}
	
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllRecEntities")
	public String deleteAllRecEntities(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		asController.deleteAllRecEntitiesByUser(user_id);		
		
		Gson gson = new Gson();
		String json = gson.toJson("deleteAllRecEntities");
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		System.out.print("/delete/deleteAllRecEntities/userID="+ userID + "/");
		System.out.println(json);
		
		return json;		
	}
	
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllProfile")
	public String deleteAllProfile(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		int oldNumberPagerankCicle = asController.getNumberPagerankCicle(user_id);

		asController.deleteAllProfileByUser(user_id);
		int numberPagerankCicle = asController.getNumberPagerankCicle(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (numberPagerankCicle < oldNumberPagerankCicle ) {			
			json = gson.toJson(numberPagerankCicle);
		}
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		
		System.out.println("oldNumberPagerankCicle: " + oldNumberPagerankCicle);
		System.out.println("numberPagerankCicle: " + numberPagerankCicle);
		System.out.print("/delete/deleteAllProfile/");
		System.out.println(json);
		
		return json;		
	}
	
	@DELETE
    @Produces(MediaType.APPLICATION_JSON)
	@Path("/deleteAllUserDetail")
	public String deleteAllUserDetail(@QueryParam("userID") String userID) throws Exception 
	{
		int user_id = Integer.parseInt(userID);
		AdaptiveSelectionController asController = new AdaptiveSelectionController();
		
		DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
		Calendar cal = Calendar.getInstance();
		System.out.println(dateFormat.format(cal.getTime()));
		int oldNumberPagerankCicle = asController.getNumberPagerankCicle(user_id);

		asController.deleteAllUserDetail(user_id);
		int numberPagerankCicle = asController.getNumberPagerankCicle(user_id);
		
		Gson gson = new Gson();
		String json = gson.toJson("null");
		if (numberPagerankCicle < oldNumberPagerankCicle ) {			
			json = gson.toJson(numberPagerankCicle);
		}

		System.out.print("/deleteAllUserDetail/");
		System.out.println(json);
		
		return json;		
	}
}






