/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package javaapplication1;

import java.io.*;
import java.lang.*;
import java.util.concurrent.TimeUnit;
/**
 *
 * @author sunny
 */
public class Execute {
    
    public static void main(String[] args){
        String l = args[1];
        String n = args[2];
        long timeInMillis = Long.valueOf(args[3]);
        System.out.println("Code started executing.");
        ProcessBuilder p = new ProcessBuilder("java", "Main");
        p.directory();
        File in = new File(n);
        p.redirectInput(in);
        if(in.exists())
            System.out.println("Input file " + in.getAbsolutePath());
        p.redirectErrorStream(true);
        System.out.println("Current directory " + System.getProperty("dir"));
        File out = new File("out.txt");

        p.redirectOutput(out);
        if(out.exists())
            System.out.println("Output file generated " + out.getAbsolutePath());
        try {

            Process pp = p.start();
            if (!(pp.waitFor(timeInMillis, TimeUnit.MILLISECONDS))) {
                System.out.println("TLE");
            }
            int exitCode = pp.exitValue();
            System.out.println("Exit Value = " + pp.exitValue());
            if(exitCode != 0){
        
                System.out.println("Time limit exceeded");
                System.exit(0);
            }
                
        } catch (IOException ioe) {
            System.err.println("in execute() "+ioe);
//        } catch (InterruptedException ex) {
//            System.err.println(ex);
//        }
        System.out.println("Code execution finished!");
        //delete executables
        System.out.println("Successfully executed");
    }
    
}
}
