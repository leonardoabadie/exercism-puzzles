/* Reference(s)
** https://www.baeldung.com/java-ternary-operator
*/

public class Twofer {
    public String twofer(String name) {
        String person = name == null ? "you" : name;
        return "One for " + person + ", one for me.";
    }
}