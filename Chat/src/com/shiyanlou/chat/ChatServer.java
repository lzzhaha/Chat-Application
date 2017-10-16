package com.shiyanlou.chat;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashSet;
import java.util.Set;

import javax.websocket.OnClose;
import javax.websocket.OnError;
import javax.websocket.OnMessage;
import javax.websocket.OnOpen;
import javax.websocket.Session;
import javax.websocket.server.ServerEndpoint;

import net.sf.json.JSONObject;



@ServerEndpoint("/websocket")
public class ChatServer {
	private static final Set<Session> clients = new HashSet<Session>();
	
	private static final SimpleDateFormat DATE_FORMAT = new SimpleDateFormat("yyyy-MM-dd HH:mm");
	
	
	private Session tail_session;
	
	@OnOpen
	
	public void open(Session session){
		
		//Operations for initialization
		clients.add(session);
		tail_session = session;
	}
	
	/*receive the message from client,
	 * and send the message to all connected Sessions
	 * @param message Message from client side
	 * @param session session from client
	 * */
	
	@OnMessage
	
	public void getMessage(String message, Session session){
		
		//Decode the message from client to JSON object
		JSONObject jsonObject = JSONObject.fromObject(message);
		
		//Append the date to the message
		jsonObject.put("date", DATE_FORMAT.format(new Date()));
		
		//Send message to all connected Sessions
		for(Session ss : clients){
			
			jsonObject.put("isSelf", ss.equals(session));
			
			ss.getAsyncRemote().sendText(jsonObject.toString());			
		}
	}
	
	@OnClose
	
	public void close(){
		//Close the current Session
		clients.remove(tail_session);
	}
	
	
	@OnError
	public void error(Throwable t) throws Throwable{
		throw t;
	}
	
}

