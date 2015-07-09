
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;

public class Execute {
    /** 
     * args[1] => question name
     * args[2] => username
     * args[3] to end => name of testcase file
     */
    public static void main(String[] args) {
//        BufferedReader reader;
//        System.out.println(args.length);
        String fileName = args[0];
//        for (int i = 0; i < args.length; i++) {
//            String tc = args[1];
            /**
             * java filename < tc >tcout.txt
             */
            ProcessBuilder p = new ProcessBuilder("java", fileName);
//            ProcessBuilder p = new ProcessBuilder("java " + fileName);
            System.out.println(p.command());
            p.directory(new File("../Uploads/Question/" + args[1] + "/Response/" + args[2] + "/"));
            p.redirectInput(new File ("../Uploads/Question/" + args[1] + "/sample/" + args[3] + ".txt"));
            p.redirectOutput(new File ("../Uploads/Question/" + args[1] + "/Response/" + args[2] + "/sample/" + args[3] +"out.txt"));
           
//            p.redirectErrorStream(true);
            try{
                Process x = p.start();
                x.waitFor();
            } catch (Exception e){
                System.out.println("Encountered error in p.start()");
                System.out.println(e);
                e.printStackTrace();
            }
//        }
    }
}
