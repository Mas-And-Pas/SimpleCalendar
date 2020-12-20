<?php

use donatj\SimpleCalendar;

class SimpleCalendarTest extends \PHPUnit\Framework\TestCase {

	public function testCurrentMonth() {
		$cal = new SimpleCalendar();
		$this->assertStringContainsString('class="today"', $cal->show(false));
	}


	public function testBadDailyHtmlDates(){
		$this->expectException(InvalidArgumentException::class);
		$cal = new SimpleCalendar('June 2010', 'June 5 2010');
		$cal->addDailyHtml('foo', 'tomorrow', 'yesterday');
	}

	public function testClasses() {
		$cal = new SimpleCalendar('June 2010', 'June 5 2010');
		$defaults = [
			'SimpleCalendar',
			'SCprefix',
			'SCsuffix',
			'today',
			'event',
			'events',
		];

		$cal->addDailyHtml( 'Sample Event', 'June 15 2010' );
		$cal_html = $cal->render();
		foreach( $defaults as $class ) {
			$this->assertStringContainsString('class="' . $class . '"', $cal_html);
		}
	}

	public function testCustomClasses() {
		$cal = new SimpleCalendar('June 2010', 'June 5 2010');
		$classes = [
			'calendar'     => 'TestCalendar',
			'leading_day'  => 'TestPrefix',
			'trailing_day' => 'TestSuffix',
			'today'        => 'TestToday',
			'event'        => 'TestEvent',
			'events'       => 'TestEvents',
		];

		$cal->setCalendarClasses( $classes );
		$cal->addDailyHtml( 'Sample Event', 'June 15 2010' );
		$cal_html = $cal->render();

		foreach( $classes as $class ) {
			$this->assertStringContainsString('class="' . $class . '"', $cal_html);
		}
	}

	public function testCurrentMonth_yearRegression() {
		$cal = new SimpleCalendar(sprintf('%d-%d-%d', (date('Y') - 1), date('n'), date('d')));
		$this->assertStringNotContainsString('class="today"', $cal->show(false));
	}

	public function testTagOpenCloseMismatch_regression() {
		$cal = new SimpleCalendar();
		$cal->setStartOfWeek(4);
		$cal->setDate('September 2016');
		$html = $cal->show(false);

		$this->assertSame(substr_count($html, '<tr'), substr_count($html, '</tr'));
		$this->assertSame(substr_count($html, '<td'), substr_count($html, '</td'));
	}

	public function testTagOpenCloseMismatch_regression2() {
		$cal = new SimpleCalendar();
		$cal->setDate('January 2017');
		$html = $cal->show(false);

		$this->assertSame(substr_count($html, '<tr'), substr_count($html, '</tr'));
		$this->assertSame(substr_count($html, '<td'), substr_count($html, '</td'));
	}

	public function testGenericGeneration() {
		$cal = new SimpleCalendar("June 5 2016");

		$tableArray = $this->parseCalendarHtml($cal);

		$expected = [
			[
				[ 'class' => '', 'text' => 'Sun', ],
				[ 'class' => '', 'text' => 'Mon', ],
				[ 'class' => '', 'text' => 'Tue', ],
				[ 'class' => '', 'text' => 'Wed', ],
				[ 'class' => '', 'text' => 'Thu', ],
				[ 'class' => '', 'text' => 'Fri', ],
				[ 'class' => '', 'text' => 'Sat', ],
			],

			[
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'disable', 'text' => '1', 'date' => '2016-06-01', ],
				[ 'class' => 'disable', 'text' => '2', 'date' => '2016-06-02', ],
				[ 'class' => 'disable', 'text' => '3', 'date' => '2016-06-03', ],
				[ 'class' => 'disable', 'text' => '4', 'date' => '2016-06-04', ],
			],

			[
				[ 'class' => 'disable', 'text' => '5', 'date' => '2016-06-05', ],
				[ 'class' => 'disable', 'text' => '6', 'date' => '2016-06-06', ],
				[ 'class' => 'disable', 'text' => '7', 'date' => '2016-06-07', ],
				[ 'class' => 'disable', 'text' => '8', 'date' => '2016-06-08', ],
				[ 'class' => 'disable', 'text' => '9', 'date' => '2016-06-09', ],
				[ 'class' => 'disable', 'text' => '10', 'date' => '2016-06-10', ],
				[ 'class' => 'disable', 'text' => '11', 'date' => '2016-06-11', ],
			],

			[
				[ 'class' => 'disable', 'text' => '12', 'date' => '2016-06-12', ],
				[ 'class' => 'disable', 'text' => '13', 'date' => '2016-06-13', ],
				[ 'class' => 'disable', 'text' => '14', 'date' => '2016-06-14', ],
				[ 'class' => 'disable', 'text' => '15', 'date' => '2016-06-15', ],
				[ 'class' => 'disable', 'text' => '16', 'date' => '2016-06-16', ],
				[ 'class' => 'disable', 'text' => '17', 'date' => '2016-06-17', ],
				[ 'class' => 'disable', 'text' => '18', 'date' => '2016-06-18', ],
			],

			[
				[ 'class' => 'disable', 'text' => '19', 'date' => '2016-06-19', ],
				[ 'class' => 'disable', 'text' => '20', 'date' => '2016-06-20', ],
				[ 'class' => 'disable', 'text' => '21', 'date' => '2016-06-21', ],
				[ 'class' => 'disable', 'text' => '22', 'date' => '2016-06-22', ],
				[ 'class' => 'disable', 'text' => '23', 'date' => '2016-06-23', ],
				[ 'class' => 'disable', 'text' => '24', 'date' => '2016-06-24', ],
				[ 'class' => 'disable', 'text' => '25', 'date' => '2016-06-25', ],
			],

			[
				[ 'class' => 'disable', 'text' => '26', 'date' => '2016-06-26', ],
				[ 'class' => 'disable', 'text' => '27', 'date' => '2016-06-27', ],
				[ 'class' => 'disable', 'text' => '28', 'date' => '2016-06-28', ],
				[ 'class' => 'disable', 'text' => '29', 'date' => '2016-06-29', ],
				[ 'class' => 'disable', 'text' => '30', 'date' => '2016-06-30', ],
				[ 'class' => 'SCsuffix', 'text' => ' ', ],
				[ 'class' => 'SCsuffix', 'text' => ' ', ],
			],
		];

		$this->assertSame($expected, $tableArray);
	}

	public function testGenericGeneration_mTs() {
		$cal = new SimpleCalendar("June 5 2016");
		$cal->setStartOfWeek(5);

		$tableArray = $this->parseCalendarHtml($cal);

		$expected = [
			[
				[ 'class' => '', 'text' => 'Fri', ],
				[ 'class' => '', 'text' => 'Sat', ],
				[ 'class' => '', 'text' => 'Sun', ],
				[ 'class' => '', 'text' => 'Mon', ],
				[ 'class' => '', 'text' => 'Tue', ],
				[ 'class' => '', 'text' => 'Wed', ],
				[ 'class' => '', 'text' => 'Thu', ],
			],
			[
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'SCprefix', 'text' => ' ', ],
				[ 'class' => 'disable', 'text' => '1', 'date' => '2016-06-01', ],
				[ 'class' => 'disable', 'text' => '2', 'date' => '2016-06-02', ],
			],
			[
				[ 'class' => 'disable', 'text' => '3', 'date' => '2016-06-03', ],
				[ 'class' => 'disable', 'text' => '4', 'date' => '2016-06-04', ],
				[ 'class' => 'disable', 'text' => '5', 'date' => '2016-06-05', ],
				[ 'class' => 'disable', 'text' => '6', 'date' => '2016-06-06', ],
				[ 'class' => 'disable', 'text' => '7', 'date' => '2016-06-07', ],
				[ 'class' => 'disable', 'text' => '8', 'date' => '2016-06-08', ],
				[ 'class' => 'disable', 'text' => '9', 'date' => '2016-06-09', ],
			],
			[
				[ 'class' => 'disable', 'text' => '10', 'date' => '2016-06-10', ],
				[ 'class' => 'disable', 'text' => '11', 'date' => '2016-06-11', ],
				[ 'class' => 'disable', 'text' => '12', 'date' => '2016-06-12', ],
				[ 'class' => 'disable', 'text' => '13', 'date' => '2016-06-13', ],
				[ 'class' => 'disable', 'text' => '14', 'date' => '2016-06-14', ],
				[ 'class' => 'disable', 'text' => '15', 'date' => '2016-06-15', ],
				[ 'class' => 'disable', 'text' => '16', 'date' => '2016-06-16', ],
			],
			[
				[ 'class' => 'disable', 'text' => '17', 'date' => '2016-06-17', ],
				[ 'class' => 'disable', 'text' => '18', 'date' => '2016-06-18', ],
				[ 'class' => 'disable', 'text' => '19', 'date' => '2016-06-19', ],
				[ 'class' => 'disable', 'text' => '20', 'date' => '2016-06-20', ],
				[ 'class' => 'disable', 'text' => '21', 'date' => '2016-06-21', ],
				[ 'class' => 'disable', 'text' => '22', 'date' => '2016-06-22', ],
				[ 'class' => 'disable', 'text' => '23', 'date' => '2016-06-23', ],
			],
			[
				[ 'class' => 'disable', 'text' => '24', 'date' => '2016-06-24', ],
				[ 'class' => 'disable', 'text' => '25', 'date' => '2016-06-25', ],
				[ 'class' => 'disable', 'text' => '26', 'date' => '2016-06-26', ],
				[ 'class' => 'disable', 'text' => '27', 'date' => '2016-06-27', ],
				[ 'class' => 'disable', 'text' => '28', 'date' => '2016-06-28', ],
				[ 'class' => 'disable', 'text' => '29', 'date' => '2016-06-29', ],
				[ 'class' => 'disable', 'text' => '30', 'date' => '2016-06-30', ],
			],
		];

		$this->assertSame($expected, $tableArray);
	}

	/**
	 * @return array
	 */
	private function parseCalendarHtml( SimpleCalendar $cal ) {
		$x = new DOMDocument();
		@$x->loadHTML($cal->show(false));

		$trs        = $x->getElementsByTagName('tr');
		$tableArray = [];
		$rowi       = 0;
		foreach( $trs as $tr ) {
			/**
			 * @var $tr \DOMElement
			 */
			$this->assertEquals(7, $tr->childNodes->length);

			$rowArray = [];
			foreach( $tr->childNodes as $childNode ) {
				/**
				 * @var $childNode \DOMElement
				 */
				$class   = $childNode->getAttribute("class");
				$rowItem = [
					'class' => $class,
					'text'  => $childNode->textContent,
				];

				if( $rowi == 0 ) {
					$this->assertEquals($childNode->tagName, 'th');
				} else {
					$this->assertEquals($childNode->tagName, 'td');

					$time = $childNode->getElementsByTagName('time');

					if( $class == 'SCprefix' || $class == 'SCsuffix' ) {
						$this->assertEquals(0, $time->length);
					} else {
						$this->assertGreaterThan(0, $time->length);
						$rowItem['date'] = $time->item(0)->getAttribute('datetime');
					}
				}

				$rowArray[] = $rowItem;
			}

			$tableArray[] = $rowArray;

			$rowi++;
		}

		return $tableArray;
	}

}
