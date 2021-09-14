package test;

import java.util.List;
import java.util.Scanner;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

import dialog.DialogFacade;
import dialog.DialogState;
import entity.Message;
import functions.InvalidMessageException;
import functions.LogService;
import functions.LogService.EventType;
import functions.TestUserMessageHandler;
import replies.Reply;
import restService.GetFirstRecommendation;
import restService.GetReply;

public class TestInterface {
	public static void main(String args []) throws Exception {
		Scanner s = new Scanner(System.in);
		DialogState state = new DialogState(1234);
		while (true) {
			System.out.print(">");
			String text = s.nextLine();
			TestUserMessageHandler tumh = new TestUserMessageHandler("1234", "test", "movierecsysbot");
			tumh.setMessage("1111", text, System.currentTimeMillis() + "");
			Reply r = tumh.handle();
			if (r.getAuxAPI() != null) {
				JsonObject params = r.getAuxAPI().getParameters();
				GetFirstRecommendation gfr = new GetFirstRecommendation();
				String recOutput = gfr.getFirstRecommendationPost(params.toString());
				System.out.println("Recommendation output is " + recOutput);
			}
			System.out.println("---MESSAGE---");
			for (Message m: r.getMessages()) {
				System.out.println(m.getText());
				System.out.println("-------");
			}
			if (r.getReplyMarkup() != null) {
				System.out.println("---BUTTONS---");
				for (String[] opts: r.getReplyMarkup().getKeyboard().getOptions()) {
					for (String o: opts) {
						System.out.print("[" + o + "]");
					}
					System.out.println();
				}
			}

			/*JsonElement j = gson.toJsonTree(wdm);
			System.out.println(j);
			wdm = gson.fromJson(j, DialogFlowDialogManager.class);*/
		}
	}
}
