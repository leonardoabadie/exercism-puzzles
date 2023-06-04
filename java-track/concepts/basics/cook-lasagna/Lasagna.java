public class Lasagna {
  int minutesInOven = 40;
  int preparingTimeForLayer = 2;

  public int expectedMinutesInOven() {
    return this.minutesInOven;
  }

  public int remainingMinutesInOven(int timeSpentInOven) {
    return this.expectedMinutesInOven() - timeSpentInOven;
  }

  public int preparationTimeInMinutes(int layersInLasagna) {
    return this.preparingTimeForLayer * layersInLasagna;
  }

  public int totalTimeInMinutes(int layersInLasagna, int timeSpentInOven) {
    return this.preparationTimeInMinutes(layersInLasagna) + timeSpentInOven;
  }
}
