class AnnalynsInfiltration {
  public static boolean canFastAttack(boolean knightIsAwake) {
    return !knightIsAwake;
  }

  public static boolean canSpy(boolean knightIsAwake, boolean archerIsAwake, boolean prisionerIsAwake) {
    return knightIsAwake || archerIsAwake || prisionerIsAwake;
  }

  public static boolean canSignalPrisoner(boolean archerIsAwake, boolean prisionerIsAwake) {
    return !archerIsAwake && prisionerIsAwake;
  }

  public static boolean canFreePrisoner(boolean knightIsAwake, boolean archerIsAwake, boolean prisionerIsAwake, boolean petDogIsPresent) {
    boolean firstTactic = !archerIsAwake && petDogIsPresent;
    boolean secondTactic = !petDogIsPresent && prisionerIsAwake && (!archerIsAwake && !knightIsAwake);
    return firstTactic || secondTactic;        
  }
}
