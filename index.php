<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="cdn/webIcon.png" sizes="any">
    <title>NFA/DFA Builder</title>
    <!-- Framworks -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- Diagram/Vis-network Intigration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .container-bg {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 0.2rem;
             !important
        }

        #outputContainer {
            background-color: #efefef;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #networkContainer {
            position: relative;
            background: #ffffff;
            height: 300px;
            border: 1px solid #ddd;
        }

        #networkContainer::before {
            content: "Not 100% Accurate, Error(s) Expected";
            position: absolute;
            top: 94%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: rgba(0, 0, 0, 0.3);
        }

        pre {
            color: #fff;
            background: #212529;
            border-radius: 5px;
            padding: 1rem;
        }

        .techStack img {
            width: 80%;
        }
    </style>



</head>

<body>
    <div class="container container-bg mt-5">
        <h2 class="mb-4 font-weight-bold text-center">NFA/DFA Builder</h2>
        <div class="small mb-2 text-center">Just a heads up, this project is a bit like a work in progress painting not quite perfect yet. You might spot a few quirks or errors here and there. I know the translation diagram is doing a funky dance; it's a bit of a character! I'm aware there's room for improvement, and I'd love your thoughts. If you notice something or have ideas, hit me up. Let's make this project even cooler together!</div>
        <div class="text-right">
            <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="importSampleData()"><i class="bi bi-file-earmark-plus"></i> Import Sample Data</button>
        </div>

        <form id="nfaDfaForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small" for="states">States (comma-separated):</label>
                        <input type="text" class="form-control form-control-sm" name="states" placeholder="states like q0, q1" required>
                    </div>
                    <div class="form-group">
                        <label class="small" for="alphabet">Alphabet (comma-separated):</label>
                        <input type="text" class="form-control form-control-sm" name="alphabet" placeholder="alphabet like a, b" required>
                    </div>
                    <div class="form-group">
                        <label class="small" for="transitions">Transitions (format: state,symbol,next_state):</label>
                        <div id="transitionsContainer">
                            <div class="transition-input">
                                <input type="text" class="form-control form-control-sm" name="transitions[]" placeholder="transition like q0,a,q0" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addTransitionInput()"><i class="bi bi-plus-circle-fill"></i> Transition</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small" for="initialState">Initial State:</label>
                        <input type="text" class="form-control form-control-sm" name="initialState" placeholder="initial state like q0" required>
                    </div>
                    <div class="form-group">
                        <label class="small" for="finalStates">Final States (comma-separated):</label>
                        <input type="text" class="form-control form-control-sm" name="finalStates" placeholder="final state like q1" required>
                    </div>
                    <div class="form-group">
                        <label class="small" for="inputsToCheck">Inputs to check (comma-separated):</label>
                        <input type="text" class="form-control form-control-sm" name="inputsToCheck" placeholder="inputs like aa, ab, bba" required>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-success" onclick="buildNfaDfa()"><i class="bi bi-check-circle-fill"></i> Build Now</button>
            </div>
        </form>

        <div id="outputContainer" class="mt-4" style="display:none;">
            <h4><b>Output</b>:</h4>
            <p id="outputText"></p>
            <div id="networkContainer" class="mt-4"></div>
        </div>
    </div>

    <div class="container col-md-6 small">
        <h4 class="mt-4 font-weight-bold">Project Information</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">University</th>
                    <td><a href="https://www.umt.edu.pk/" target="_blank">
                            University of Management and Technology
                            <i class="bi bi-link-45deg"></i>
                        </a></td>
                </tr>
                <tr>
                    <th scope="row">Subject</th>
                    <td>Theory of Automata</td>
                </tr>
                <tr>
                    <th scope="row">Course Code</th>
                    <td>CS3043</td>
                </tr>
                <tr>
                    <th scope="row">Section</th>
                    <td>V10</td>
                </tr>
                <tr>
                    <th scope="row">Professor</th>
                    <td><a href="https://www.linkedin.com/in/ranamarwathussain1" target="_blank">
                            Rana Marwat
                            <i class="bi bi-linkedin"></i>
                        </a></td>
                </tr>
                <tr>
                    <th scope="row">Files</th>
                    <td><a href="cdn/documents/NFA_DFA_Presentation.pptx" download>Download Presentation (PPT) <i class="bi bi-cloud-arrow-down-fill"></i></a></td>
                </tr>
            </tbody>
        </table>

        <h4 class="mt-4 font-weight-bold">Project Tech Stack</h4>
        <div class="techStack text-center">
            <img src="cdn/tech-stack.png" alt="PHP, HTML, CSS, JS/AJAX, Bootstrap, ChatGPT">
        </div>

        <div>
            <div>
                <h4 class="mt-4 font-weight-bold">Project Algorithm</h4>

                <p>NFA/DFA Structure (Class)</p>
                <pre><code class="php">
class NFA_DFA {
    // Private properties to store NFA/DFA components
    private $states = [];
    private $alphabet = [];
    private $transitions = [];
    private $initialState = '';
    private $finalStates = [];

    // Public methods to modify NFA/DFA components
    public function addState($state) {
        // Hint: Add the given state to the list of states
    }

    public function addAlphabetSymbol($symbol) {
        // Hint: Add the given symbol to the alphabet
    }

    public function addTransition($fromState, $symbol, $toState) {
        // Hint: Add the transition information to the transitions list
    }

    public function setInitialState($state) {
        // Hint: Set the initial state for the NFA/DFA
    }

    public function addFinalState($state) {
        // Hint: Add the given state to the list of final states
    }

    // Method to process user input and determine acceptance
    public function processInput($input) {
        // Hint: Implement the logic to process the input and determine acceptance or rejection
    }

    // Method to generate a transition table for visualization
    public function getTransitionTable() {
        // Hint: Generate an HTML table representing the transition table
    }

    // Method to generate data for the transition diagram
    public function getTransitionDiagramData() {
        // Hint: Generate an array containing nodes and edges for the transition diagram
    }
}
    </code></pre>

                <p>Form (Data) Processing NFA/DFA Initialization</p>
                <pre><code class="php">
// Retrieve form data from POST request
// Hint: Use $_POST to retrieve data from the form

// Create an instance of the NFA_DFA class
$nfa_dfa = new NFA_DFA();

// Add states, alphabet, transitions, initial state, and final states to the NFA_DFA instance
// Hint: Use the methods of NFA_DFA to add components based on form data
    </code></pre>

                <p>Input Processing and Result Generation</p>
                <pre><code class="php">
// Process each input using the NFA_DFA instance
$output = '';
foreach ($inputsToCheck as $input) {
    $result = $nfa_dfa->processInput(trim($input));
    $output .= "Input: $input - Result: $result\n";
}
$output .= "&lt;br&gt;";

// Generate a transition table for visualization
$data = $nfa_dfa->getTransitionDiagramData();

// Construct a response with processed input results and transition table
$response = [
    'output' => nl2br($output . $nfa_dfa->getTransitionTable()),
    'diagramData' => $data
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
    </code></pre>
            </div>

        </div>

        <!-- Copyright information -->
        <footer class="py-3">
            <div class="container">
                <p class="mb-4">
                    &copy; <a href="">NFA/DFA Builder</a>. All rights reserved.
                    Unauthorized copying or reproduction of this project, in whole or in part, without express written
                    permission is prohibited. But hey, we're all friends here - if you want to use something, just shoot me
                    an
                    email and let's talk it out over virtual coffee!
                </p>
                <p class="mb-4">
                    Powered by coffee, sleepless nights, and a sprinkle of magic code dust.
                </p>
                <p class="mb-4">
                    For support, drop a line to <a href="mailto:ahmed@etarbiyat.com">ahmed@etarbiyat.com</a>. If you're
                    feeling
                    adventurous or just want to say hi, catch me on LinkedIn:
                    <a href="https://www.linkedin.com/in/callmeahmedr/" target="_blank">
                        <i class="fab fa-linkedin"></i> callmeahmedr
                    </a>.
                </p>
                <p class="mb-4">
                    P.S. It took me longer to build this than it takes for a developer to find the missing semicolon. If you
                    have any questions, don't hesitate to ask. I promise I won't respond with "Have you tried turning it
                    off
                    and on again?"
                </p>
            </div>
        </footer>
    </div>

    <script>
        // Function - add transition input fields
        function addTransitionInput() {
            const container = document.getElementById('transitionsContainer');
            const newInput = document.createElement('div');
            newInput.className = 'transition-input';
            newInput.innerHTML = '<input type="text" class="form-control form-control-sm" name="transitions[]" required>';
            container.appendChild(newInput);
        }

        // Function - build the nfa/dfa
        function buildNfaDfa() {
            const form = document.getElementById('nfaDfaForm');

            if (isFormEmpty(form)) {
                alert('Form is empty. Please fill in the required fields.');
                return;
            }

            const formData = new FormData(form);

            fetch('process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('outputText').innerHTML = data.output;

                    const container = document.getElementById('networkContainer');

                    const networkData = {
                        nodes: new vis.DataSet(data.diagramData.nodes),
                        edges: new vis.DataSet(data.diagramData.edges)
                    };

                    const options = {
                        nodes: {
                            color: {
                                background: 'red',
                                border: 'blue'
                            }
                        }
                    };

                    const network = new vis.Network(container, networkData, options);


                    const outputContainer = document.getElementById('outputContainer');
                    outputContainer.style.display = 'block';

                    outputContainer.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
        }

        // Function- check if the form is empty
        function isFormEmpty(form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            for (const input of inputs) {
                if (input.type !== 'submit' && input.type !== 'button' && input.value.trim() !== '') {
                    return false;
                }
            }
            return true;
        }


        // Function - importing sample data for testing
        function importSampleData() {
            const sampleData = {
                states: 'q0, q1',
                alphabet: 'a, b',
                transitions: ['q0,a,q0', 'q0,b,q1', 'q1,a,q1', 'q1,b,q1'],
                initialState: 'q0',
                finalStates: 'q1',
                inputsToCheck: 'aa, ab, bba',
            };

            for (const key in sampleData) {
                const value = sampleData[key];
                const inputElement = document.querySelector(`[name="${key}"]`);

                if (inputElement) {
                    inputElement.value = value;
                }

                if (key === 'transitions') {
                    const container = document.getElementById('transitionsContainer');
                    container.innerHTML = '';

                    value.forEach(transition => {
                        const newInput = document.createElement('div');
                        newInput.className = 'transition-input';
                        newInput.innerHTML = `<input type="text" class="form-control form-control-sm" name="transitions[]" value="${transition}" required>`;
                        container.appendChild(newInput);
                    });
                }
            }
        }
    </script>
</body>

</html>
