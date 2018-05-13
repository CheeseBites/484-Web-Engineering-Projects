import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;
public class Project2 {
       
    
    public static Scanner scanner;
    public static String a, b, c;
    public static int d, e, f;
    
    public static void main(String[] args) {
        readFile("input2.txt");
       System.out.println("The LCS is " +findLCS());
        
        
           
    }
    
    public static void readFile(String fileName){
         try {
            scanner = new Scanner(new File(fileName));
        } catch (FileNotFoundException fnf) {
            System.out.println("The file you have specified was not found");
        }
        
         if(scanner.hasNextLine()){
             a=scanner.nextLine();
         }
          if(scanner.hasNextLine()){
             b=scanner.nextLine();
         }
           if(scanner.hasNextLine()){
             c=scanner.nextLine();
         }
           
           d= a.length()+1;
           e= b.length()+1;
           f= c.length()+1;
           
    }
    
    public static int findLCS(){
        int LCS[][][] = new int[d][e][f];
        for(int x=0; x<=d-1; x++)
        {
            for(int y=0; y<=e-1; y++)
            {
                for(int z=0; z<=f-1; z++)
                {
                    //case 1, if first row/col/z axis fill the first line with 0's
                    if(x==0|| y==0|| z==0){
                        LCS[x][y][z] = 0;
                    }
                    
                    //case 2, if chars match at x y z, then add 1 from the diagnol  
                    else if(a.charAt(x-1) == b.charAt(y-1) && a.charAt(x-1) ==
                            c.charAt(z-1)){
                        LCS[x][y][z]= LCS[x-1][y-1][z-1]+1;
                    }
                    
                    //case 3, if they don't match, take the max from the adjacent
                    //boxes
                    
                    else{
                        int max;
                        max = Math.max(LCS[x-1][y][z], LCS[x][y-1][z]);
                        LCS[x][y][z]= Math.max(max,LCS[x][y][z-1]);
                    }
                }
            }
        }
        return LCS[d-1][e-1][f-1];
    }
    
    
}
