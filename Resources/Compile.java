/*
 * Check for any type of malicious program ---- IMPORTANT
 */
package javaapplication1;

import java.io.*;
import java.lang.*;

public class Compile {

   public static void main(String[] args) {
        boolean compiled=true;
        ProcessBuilder p = new ProcessBuilder("javac", "/home/sunny/Desktop/sunnyc.java");
        p.directory();
        p.redirectErrorStream(true);
        try{
            Process pp = p.start();
            InputStream is = pp.getInputStream();
            String temp;
            try (BufferedReader b = new BufferedReader(new InputStreamReader(is))) {
                b.readLine();
                temp = b.readLine();
                if (temp != null){
                    compiled = false;
//                    System.out.println(temp);
                }
//                while ((temp = b.readLine()) != null) {
//                    compiled = false;
//                    System.out.println(temp);
//                }
                pp.waitFor();
            }
            // if compiled is false then goes insde the if statement
            if (!compiled) {
                is.close();
                System.out.println("COMPILE_ERROR");
                System.exit(0);
            }
            is.close();
            System.out.println("COMPILE_SUCCESS");
        }catch(IOException | InterruptedException e){
           System.out.println("in compile() " + e);
       }
//       System.out.println("compile error 2");
   }
}