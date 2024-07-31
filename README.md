# NFA/DFA Builder
The NFA/DFA Builder is a web application designed to help users create and analyze Non-deterministic Finite Automata (NFA) and Deterministic Finite Automata (DFA). The tool allows you to input states, alphabets, transitions, and other parameters to build and visualize NFA/DFA machines. It provides a user-friendly interface with options to import sample data, add transitions dynamically, and view results and visualizations.

![NFA/DFA Output](https://github.com/callmeahmedr/nfa-dfa-builder/blob/main/cdn/documents/nfa-dfa.png)

_Just a heads up, this project is a bit like a work in progress painting not quite perfect yet. You might spot a few quirks or errors here and there. I know the translation diagram is doing a funky dance; it's a bit of a character! I'm aware there's room for improvement, and I'd love your thoughts. If you notice something or have ideas, hit me up. Let's make this project even cooler together!_

## HTML Form
![Front End Form](https://github.com/callmeahmedr/nfa-dfa-builder/blob/main/cdn/documents/nfa-df-form.png)

## Features

- **State Management**: Add and manage states for your automaton.
- **Alphabet Management**: Define the alphabet symbols used in the automaton.
- **Transition Definition**: Specify transitions between states based on symbols.
- **Initial and Final States**: Set the initial state and define final states.
- **Input Testing**: Test various input strings to check acceptance or rejection.
- **Visualization**: Generate and view transition tables and diagrams.

## How It Works

1. **Input Data**: Enter states, alphabet symbols, transitions, initial state, final states, and inputs to check in the form.
2. **Build Automaton**: Click "Build Now" to process the input and generate results.
3. **View Results**: See the transition table, acceptance results for inputs, and a visual diagram of the automaton.

## Tech Stack

- **Frontend**: HTML, CSS, Bootstrap 4.3.1, JavaScript
- **Backend**: PHP
- **Visualization**: Vis.js

## Code Overview
## HTML Structure
The HTML file sets up the form for user input and includes Bootstrap for styling. It also integrates vis.js for visualization.

## JavaScript Functions
- addTransitionInput(): Adds a new input field for transitions.
- buildNfaDfa(): Processes the form data, sends it to the server, and displays the results.
- isFormEmpty(): Checks if the form is empty before submission.
- importSampleData(): Fills the form with sample data for testing.
## PHP Backend (process.php)
- Class NFA_DFA: Defines the methods to build and process the NFA/DFA.
- addState(), addAlphabetSymbol(), addTransition(), setInitialState(), addFinalState(): Methods for adding components to the automaton.
- processInput(): Processes input strings and checks acceptance.
- getTransitionTable(): Generates an HTML table for the transition table.
- getTransitionDiagramData(): Prepares data for visualization.

# NFA/DFA Builder

## Project Information

- **University**: University of Management and Technology
- **Subject**: Theory of Automata
- **Course Code**: CS3043
- **Section**: V10
- **Professor**: Rana Marwat
- **Files**: [Download Presentation (PPT)](https://github.com/callmeahmedr/nfa-dfa-builder/blob/main/cdn/documents/NFA_DFA_Presentation.pptx)

## Contributing

Feel free to contribute to the project by submitting issues or pull requests. If you have suggestions or improvements, please reach out.

## Contact

For support or questions, email [f2021266189@umt.edu.pk](mailto:f2021266189@umt.edu.pk) or connect with me on [LinkedIn](https://www.linkedin.com/in/callmeahmedr/).
