<?php

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'ProblemSets extension', 
	'version' => 0.0, 
	'author' => 'Kendrick Shaw and Jeffrey Gill',
	'url' => 'https://slugoffice8.case.edu:8080/neurowiki',
	'description' => 'Allows students to enter answers and scores them.',
	'descriptionmsg' => 'ProblemSets-desc',
);

$wgExtensionMessagesFiles['ProblemSets'] = dirname( __FILE__ ) . '/ProblemSets.i18n.php';

// Create the extension's database tables when update.php is run
$wgHooks['LoadExtensionSchemaUpdates'][] = 'problemsetsSchemaUpdates';
function problemsetsSchemaUpdates( $updater = null ) {
        if ( $updater === null ) {
                // <= 1.16 support
                global $wgExtNewTables, $wgExtModifiedFields;
                $wgExtNewTables[] = array(
                        'problemset',
                        dirname( __FILE__ ) . '/problemset.sql'
                );
                $wgExtNewTables[] = array(
                        'problemset_attempt',
                        dirname( __FILE__ ) . '/problemset_attempt.sql'
                );
                $wgExtNewTables[] = array(
                        'problemset_question',
                        dirname( __FILE__ ) . '/problemset_question.sql'
                );
                $wgExtNewTables[] = array(
                        'problemset_response',
                        dirname( __FILE__ ) . '/problemset_response.sql'
                );
        } else {
                // >= 1.17 support
                $updater->addExtensionUpdate( array( 'addTable', 'problemset',
                        dirname( __FILE__ ) . '/problemset.sql', true ) );
                $updater->addExtensionUpdate( array( 'addTable', 'problemset_attempt',
                        dirname( __FILE__ ) . '/problemset_attempt.sql', true ) );
                $updater->addExtensionUpdate( array( 'addTable', 'problemset_question',
                        dirname( __FILE__ ) . '/problemset_question.sql', true ) );
                $updater->addExtensionUpdate( array( 'addTable', 'problemset_response',
                        dirname( __FILE__ ) . '/problemset_response.sql', true ) );
        }
        return true;
}

$wgHooks['ParserAfterTidy'][] = 'problemsetsParserAfterTidy';
$wgHooks['ParserFirstCallInit'][] = 'problemsetsSetup';
 
function problemsetsSetup( &$parser ) {
        $parser->setHook( 'problemset', 'problemsetsProblemSetParserHook' );
        $parser->setHook( 'question', 'problemsetsQuestionParserHook' );
	return true;
}
 
$problemsetsMarkerList = array();
$problemsetsCurrentProblemSet = "";

function problemsetsProblemSetParserHook($input, $argv, $parser) {
        global $problemsetsMarkerList;
        global $problemsetsCurrentProblemSet;
        global $wgUser;

	// caching creates additional potential bugs, so we disable it for now
	$parser->disableCache();

	$result = "";
	
	// add the opening text
        $output = "Welcome to problem set <b>".$argv['name']."</b>, ".$wgUser->getRealName()."!";
        $markercount = count($problemsetsMarkerList);
        $problemsetsMarkerList[$markercount] = $output;
        $result = $result."problemsets-marker".$markercount."-problemsets";

	// add the body
	$oldProblemSet = $problemsetsCurrentProblemSet;
	$problemsetsCurrentProblemSet = $argv['name'];
	$result = $result.$parser->recursiveTagParse($input);
	$problemsetsCurrentProblemSet = $oldProblemSet;

	// add the closing text
        $output = "Thanks for visiting problem set <em>".$argv['name']."</em>!";
        $markercount = count($problemsetsMarkerList);
        $problemsetsMarkerList[$markercount] = $output;
        $result = $result."problemsets-marker".$markercount."-problemsets";

        return $result;
}

function problemsetsQuestionParserHook($input, $argv, $parser) {
        global $problemsetsMarkerList;
        global $problemsetsCurrentProblemSet;
        $output = "What is your answer for question ".$argv['question']." of problem set ".$problemsetsCurrentProblemSet."?<input/>";
        $markercount = count($problemsetsMarkerList);
        $problemsetsMarkerList[$markercount] = $output;
        $marker = "problemsets-marker".$markercount."-problemsets";
        return $marker;
}
 
function problemsetsParserAfterTidy($parser, &$text) {
        // find markers in $text
        // replace markers with actual output
        global $problemsetsMarkerList;
        $keys = array();
        $marker_count = count($problemsetsMarkerList);
 
        for ($i = 0; $i < $marker_count; $i++) {
                $keys[] = 'problemsets-marker' . $i . '-problemsets';
        }
 
        $text = str_replace($keys, $problemsetsMarkerList, $text);
        return true;
}

