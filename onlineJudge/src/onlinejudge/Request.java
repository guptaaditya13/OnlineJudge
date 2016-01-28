/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package onlinejudge;

/**
 *
 * @author aadi
 */
public class Request extends Thread{
    String name;
    String type;
    
    Request(String name, String type){
        this.name = name;
        this.type = type;
    }
    
    public static void main(String[] args) {
        
    }
    
    public void run(){
        if(type.equalsIgnoreCase("JAVA")){
            JAVA code = new JAVA(name);
            
            String output = code.compile(10);
            
            
            
        }
        
    }
}
