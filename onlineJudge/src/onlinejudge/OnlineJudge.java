/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package onlinejudge;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.ServerSocket;
import java.net.Socket;
import org.json.simple.JSONArray;
import org.json.simple.parser.JSONParser;
/**
 *
 * @author aadi
 */
public class OnlineJudge {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException {
        ServerSocket server = new ServerSocket(2000);
        Socket s;
        while(true){
            s = server.accept();
            System.out.println("New connection accepted " + s.toString());
            JSONParser parser = new JSONParser();
            BufferedReader in = new BufferedReader(new InputStreamReader(s.getInputStream()));
            String jsonInp = in.readLine();
            String name = null, type = null;
            try{
                JSONArray arr = (JSONArray) parser.parse(jsonInp);
               
                name = (String)arr.get(0);
                type = (String)arr.get(1);
            } catch (Exception e) {
                System.out.println("Invalid JSON, terminated.");
                continue;
            }
            Request req = new Request(name,type);
        }
    }
    
}
