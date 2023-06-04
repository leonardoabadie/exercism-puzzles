class ReverseString {
  String reverse(String inputString) {
    String reverseString = "";
    char[] inputChars = inputString.toCharArray();
    for (int iterator = 0; iterator < inputChars.length; iterator++) {
      reverseString = inputChars[iterator] + reverseString;
    }
    
    return reverseString;
  }
}
