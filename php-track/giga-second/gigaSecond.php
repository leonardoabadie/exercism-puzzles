<?php
function from(DateTimeImmutable $date): DateTimeImmutable {
	$newDate = new DateTime();
	$newDate->setTimestamp($date->getTimestamp());
	$newDate->add(new DateInterval('P0YT1000000000S'));

  return DateTimeImmutable::createFromMutable($newDate);
}
?>
