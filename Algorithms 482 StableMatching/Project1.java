import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;

public class Project1 {

    public static Scanner scanner;
    public static int menP[][];
    public static int womenP[][];
    public static int pairs[];
    public static int n;
    public static boolean successful = true;

    public static void main(String[] args) {
        //Lazy way of setting up the arrays@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        try {
            scanner = new Scanner(new File("input1.txt"));
        } catch (FileNotFoundException fnf) {
            System.out.println("The file you have specified was not found");
        }

        n = scanner.nextInt();
        scanner.nextLine();

        menP = new int[n][n];
        womenP = new int[n][n + 1];
        pairs = new int[n];
        for (int i = 0; i < n; i++) {
            if (scanner.hasNextInt()) {
                for (int j = 0; j < n; j++) {
                    menP[i][j] = scanner.nextInt();
                }
            }
        }

        for (int i = 0; i < n; i++) {
            if (scanner.hasNextInt()) {
                for (int j = 0; j < n; j++) {
                    womenP[i][j] = scanner.nextInt();
                }
            }
        }

        for (int i = 0; i < n; i++) {
            if (scanner.hasNextInt()) {
                pairs[i] = scanner.nextInt();
            }
        }

        for (int i = 0; i < n; i++) {
            womenP[pairs[i] - 1][n] = i + 1;
        }

        //end of Lazy way of setting up the arrays@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        if (successful) {
            outerloop:
            //First for loop iterates through the men
            for (int i = 0; i < n; i++) {
                //Second for loop iterates through man [n]s list of women
                for (int k = 0; k < n; k++) {
                    //if the first woman on man [n]s preference is also his match
                    //then just move to the next man because the match is successful
                    if (menP[i][k] == pairs[i]) {
                        for (int z = 0; z < n; z++) {
                            womenP[k][z] = -1;
                            menP[i][z] = -1;
                        }
                        break;
                    } //else check man [n]s list of women and go through it until 
                    //it reaches his match, then go through the women that he prefers
                    //and look at their preferences, if they both prefer each other
                    //then there is an unsuccessful match and end.
                    else {

                        for (int j = 0; j < n; j++) {
                            if (womenP[k][j] != womenP[k][n]) {
                                if (womenP[k][j] == i + 1 && menP[i][0] != -1) {
                                    System.out.println("Unstable because " + (i + 1) + "," + (k + 1));
                                    successful = false;
                                    break outerloop;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (successful) {
            System.out.println("Yes");
        }
    }

}
