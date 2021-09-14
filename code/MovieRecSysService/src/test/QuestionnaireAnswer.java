package test;

public class QuestionnaireAnswer {
	private int userID;
	private int questionID;
	private int answerID;
	public QuestionnaireAnswer(int userID, int questionID, int answerID) {
		super();
		this.userID = userID;
		this.questionID = questionID;
		this.answerID = answerID;
	}
	public int getUserID() {
		return userID;
	}
	public int getQuestionID() {
		return questionID;
	}
	public int getAnswerID() {
		return answerID;
	}
	
}
