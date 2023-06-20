import './App.css';
import MasterclassQuizz from './components/MasterclassQuizz/MasterclassQuizz';
import {jsQuizz} from "./constants";

function App() {

  return (
    <MasterclassQuizz questions={jsQuizz.questions} />
  )
}

export default App
