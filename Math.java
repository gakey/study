package study;

public class Math {

	public int Fibonacci(int n){
		switch(n){
		case 0:
			return 0;
		case 1:
			return 1;
		default:
			return Fibonacci(n-1) + Fibonacci(n-2);
		}
	}

	public int reverseDigit(int n){

		String digitStr = "";

		do {
			int remain = n % 10;
			n = n / 10;
			digitStr += String.valueOf(remain);
		} while (n > 0);

		return Integer.parseInt(digitStr);
	}

}
