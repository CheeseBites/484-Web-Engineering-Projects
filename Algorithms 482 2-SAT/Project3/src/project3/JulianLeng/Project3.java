/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.LineNumberReader;
import java.util.*;

public class Project3 {
    
public static Scanner scanner;
public static int tSteps;
public static int numLines; //total lines in the file
public static int numVars; //highest variable number
public static ArrayList<Integer> col1, col2;
public static boolean[] bools;
public static String combin = "0";
public static int offset = 1;
public static int countedSteps = 0;
public static int bestSteps;
public static String bestString;
public static HashMap<Integer,Integer> total;
public static int highestVal;
public static int highestKey;

    public static void main(String[] args) {
        Scanner s = new Scanner(System.in);
        total = new HashMap<>();
        numLines = countLineNumber();
        numVars = 0;
        col1= new ArrayList<>();
        col2 = new ArrayList<>();
        readFile("input3.txt");
        System.out.println("Would you like");
        System.out.println("1) True Optimal Solution(Slow)");
        System.out.println("2) Pretty Good Solution(Fast)");
        String userInput = s.next();
        if(userInput.equals("1")){
        tSteps = (int)Math.pow(2, numVars);
        for(int i=1; i<numVars; i++){
            combin = "0" + combin;
        }
        bestString = combin;
        solver();
        bestString = bestString.replaceAll("1", "T");
        bestString = bestString.replaceAll("0", "F");
        System.out.println(bestSteps + " " +bestString );
        }
        else if(userInput.equals("2")){
        prettyGoodSolution();
        }else{
            System.out.println("Not an option, please try again");
        }
    }
    public static void prettyGoodSolution(){
        int maxVal = Collections.max(total.values());
        String answer = "";
        for(Map.Entry<Integer, Integer> entry : total.entrySet()){
            if(entry.getValue() == maxVal){
                highestKey = entry.getKey();
                highestVal = entry.getValue();
                
                if(highestKey < 0){
                    while(answer.length()<numVars){
                        if(answer.length()+1==Math.abs(highestKey)){
                        answer+="F";
                        }
                        else{
                        answer += "T";
                        }
                    }
                    System.out.println(highestVal +" "+ answer);
                }
                else{
                    while(answer.length()<numVars){
                        if(answer.length()+1==Math.abs(highestKey)){
                            answer+="T";
                        }else{
                            answer+="F";
                        }
                    }
                System.out.println(highestVal +" "+ answer);
                }
                break;
            }
        }
        
    }
    public static void solver(){
        for(int j=0; j< tSteps; j++){
            
            for(int i=0; i < col1.size(); i++){
                int a, b;
                a = col1.get(i);
                b = col2.get(i);
                boolean c = false, d = false;
                if(combin.charAt(Math.abs(a)-1) == '0'){
                    if(a < 0){
                        c = true;
                    }else
                        c = false;
                }
                if(combin.charAt(Math.abs(a)-1) == '1'){
                    if(a<0){
                        c = false;
                    }else
                        c = true;
                }
                //!!!!~~~~~~~~~~~~~~~~~~~~~~~~~
                //--------------------------------
                 if(combin.charAt(Math.abs(b)-1) == '0'){
                    if(b < 0){
                        d = true;
                    }else
                        d = false;
                }
                if(combin.charAt(Math.abs(b)-1) == '1'){
                    if(b<0){
                        d = false;
                    }else
                        d = true;
                }
                if(c||d){
                countedSteps++;
                }
            }
            if(countedSteps>bestSteps){
                bestSteps = countedSteps;
                bestString = combin;
            }
            countedSteps = 0;
            
            combin = Integer.toBinaryString(Integer.valueOf(combin, 2) + 1);
            while(combin.length()<numVars){
                combin = "0" + combin;
            }
        }
    }
    
    public static void readFile(String fileName){
         try {
            scanner = new Scanner(new File(fileName));
        } catch (FileNotFoundException fnf) {
            System.out.println("The file you have specified was not found");
        }
        
         while(scanner.hasNextLine()){
             int a, b;
             a = scanner.nextInt();
             col1.add(a);
             b = scanner.nextInt();
             col2.add(b);
             if(Math.abs(a)>numVars){
                 numVars=Math.abs(a);
             }
             if(Math.abs(b)>numVars){
                 numVars=Math.abs(b);
             }
             if(total.containsKey(a)){
                 int temp = total.get(a);
                 total.put(a,++temp);
             }else{
                 total.put(a, 1);
             }
             if(total.containsKey(b)){
                 int temp = total.get(b);
                 total.put(b,++temp);
             }else{
                 total.put(b, 1);
             }
         }   
    }
    
     public static int countLineNumber() {
         int lines = 0;
         FileReader fr = null;
         LineNumberReader lnr = null; 
         String str;
        try {
            fr = new FileReader("input3.txt");
            lnr = new LineNumberReader(fr);
            while((str = lnr.readLine())!=null){
                lines = lnr.getLineNumber();
            }
            lnr.close();
 
        } catch (FileNotFoundException e) {
            System.out.println("FileNotFoundException Occurred" + e.getMessage());
        } catch (IOException e) {
            System.out.println("IOException Occurred" + e.getMessage());
        }
        
        return lines;
    }
     
}
