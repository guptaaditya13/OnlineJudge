/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package onlinejudge;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.util.concurrent.TimeUnit;

/**
 *
 * @author aadi
 */
public class JAVA {
    String name;
    
    JAVA(String name){
        this.name = name;        
    }
    
    public String[] compile(int time) throws InterruptedException, IOException{
//        File compScript = new File("JAVAcompile.sh");
//        try {
//            if(!compScript.createNewFile()){
//                String[] out = { "-1","Unable to Compile. Contact sysAdmin."};
//                return out;
//            }
//        } catch (IOException ex) {
//            String[] out = { "-1","Unable to Compile. Contact sysAdmin."};
//            return out;
//        }
//        
        PrintWriter writer;
        try {
            writer = new PrintWriter("JAVAcompile.sh", "UTF-8");
        } catch (FileNotFoundException | UnsupportedEncodingException ex) {
            String[] out = { "-1","Unable to Compile. Contact sysAdmin. Error - 1"};
            return out;
        }
        writer.println("javac " + name + ".java");
        writer.flush();
        writer.close();
        Runtime r = Runtime.getRuntime();
        Process p = r.exec("chmod +x JAVAcompile.sh");
        if(!p.waitFor(10, TimeUnit.SECONDS)){
            String[] out = { "-1","Unable to Compile. Contact sysAdmin. Error - 2"};
            return out;
        }
        
    }
}
