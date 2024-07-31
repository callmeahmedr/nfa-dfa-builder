<?php

class NFA_DFA {
    private $states = [];
    private $alphabet = [];
    private $transitions = [];
    private $initialState = '';
    private $finalStates = [];

    public function addState( $state ) {
        $this->states[] = $state;
    }

    public function addAlphabetSymbol( $symbol ) {
        $this->alphabet[] = $symbol;
    }

    public function addTransition( $fromState, $symbol, $toState ) {
        $this->transitions["$fromState,$symbol"] = $toState;
    }

    public function setInitialState( $state ) {
        $this->initialState = $state;
    }

    public function addFinalState( $state ) {
        $this->finalStates[] = $state;
    }

    public function processInput( $input ) {
        $currentState = $this->initialState;

        for ( $i = 0; $i < strlen( $input );
        $i++ ) {
            $symbol = $input[$i];

            $key = "$currentState,$symbol";

            if ( !isset( $this->transitions[$key] ) ) {
                return "Invalid transition for input '$symbol' from state '$currentState'.";
            }

            $currentState = $this->transitions[$key];
        }

        return in_array( $currentState, $this->finalStates ) ? "<span class='text-success'>Accepted</span>" : "<span class='text-danger'>Rejected</span>";
    }

    public function getTransitionTable() {
        $table = "<h4><b>Transition Table</b>:</h4>";
        $table .= "<table class='table table-bordered'>";
        $table .= "<thead style='background: #333;color: #fff;'><tr><th>State</th>";

        // Table header with alphabet symbols
        foreach ( $this->alphabet as $symbol ) {
            $table .= "<th>$symbol</th>";
        }

        $table .= "</tr></thead><tbody>";

        // Table body with transitions
        foreach ( $this->states as $state ) {
            $table .= "<tr><th>$state</th>";

            foreach ( $this->alphabet as $symbol ) {
                $key = "$state,$symbol";
                $toState = isset( $this->transitions[$key] ) ? $this->transitions[$key] : '-';
                $table .= "<td>$toState</td>";
            }

            $table .= "</tr>";
        }

        $table .= "</tbody></table>";

        return $table;
    }

    public function getTransitionDiagramData() {
        $data = [
            'nodes' => [],
            'edges' => []
        ];

        // Add nodes
        foreach ( $this->states as $state ) {
            $data['nodes'][] = ['id' => $state, 'label' => $state];
        }

        // Add edges
        foreach ( $this->states as $fromState ) {
            foreach ( $this->alphabet as $symbol ) {
                $key = "$fromState,$symbol";
                $toState = isset( $this->transitions[$key] ) ? $this->transitions[$key] : '-';

                if ( $toState !== '-' ) {
                    $data['edges'][] = ['from' => $fromState, 'to' => $toState, 'label' => $symbol];
                }
            }
        }

        return $data;
    }
}

// Get user input from the form
$states = explode( ',', $_POST['states'] );
$alphabet = explode( ',', $_POST['alphabet'] );
$transitions = $_POST['transitions'];
$initialState = $_POST['initialState'];
$finalStates = explode( ',', $_POST['finalStates'] );
$inputsToCheck = explode( ',', $_POST['inputsToCheck'] );

// Create an instance of NFA_DFA
$nfa_dfa = new NFA_DFA();

// Add states, alphabet, transitions, initial state, and final states
foreach ( $states as $state ) {
    $nfa_dfa->addState( trim( $state ) );
}

foreach ( $alphabet as $symbol ) {
    $nfa_dfa->addAlphabetSymbol( trim( $symbol ) );
}

foreach ( $transitions as $transition ) {
    list( $fromState, $symbol, $toState ) = array_map( 'trim', explode( ',', $transition ) );
    $nfa_dfa->addTransition( $fromState, $symbol, $toState );
}

$nfa_dfa->setInitialState( trim( $initialState ) );

foreach ( $finalStates as $finalState ) {
    $nfa_dfa->addFinalState( trim( $finalState ) );
}

// Process each input and build the output
$output = '';
foreach ( $inputsToCheck as $input ) {
    $result = $nfa_dfa->processInput( trim( $input ) );
    $output .= "Input: $input - Result: $result\n";
}
$output .= "<br>";

// Display result with transition table
$data = $nfa_dfa->getTransitionDiagramData();
$response = [
    'output' => nl2br( $output . $nfa_dfa->getTransitionTable() ),
    'diagramData' => $data
];

// Send the response as JSON
header( 'Content-Type: application/json' );
echo json_encode( $response );
