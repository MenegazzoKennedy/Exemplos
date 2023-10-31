import java.util.Scanner;

public class GeradorByteCode {

	public GeradorByteCode() {
		// TODO Auto-generated constructor stub
	}
	
	public String gerar(String linha) {
		String[] token = linha.split(" ");
		
		if (token[0].equals("tutaj")){
			return "int " + token[1];
		}
		if (token[0].equals("int")) {
			return "int " + token[1];
		}
		
		if (token[0].equals("legi")) {
			return token[1].replace(";","") + "=teclado.nextInt();";
		}
		if (token[0].equals("por"))
			return token[0] + " " + token[1] + " " + token[2] + " " + token[3] + " " + token[4] + " " + token[5] + " " + token[6];
		
		if (token[0].equals("se"))
			return token[0] + " " + token[1] + " " + token[2] + " " + token[3] + " " + token[4];
		
		if (token[0].equals("presi"))
			return token[0] + " " + token[1];
		
		if (token[0].equals("finise"))
			return token[0] + " " + token[1];
		
		if (token[0].equals("finise"))
			return token[0] + " " + token[1];
		
		if (token[0].equals("pusi"))
			return token[0] + " " + token[1];
		
		if (token[0].equals("reveni"))
			return token[0] + " " + token[1];
		
		
		return "";
		
	}

}
