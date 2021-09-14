package functions;

import java.util.List;

public class FakeLog extends LogService {

	@Override
	public void insertMessageInLog(int userID, String messageID, String message, long timestampStart, long timestampEnd,
			String intent, String contexts, List<String> recognized, List<String> events, String interactionType) {
		// TODO Auto-generated method stub
	}

	@Override
	public void insertMessageInLog() {
		// TODO Auto-generated method stub
	}

}
