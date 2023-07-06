import React, { useEffect, useState } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import './MasterclassQuizz.scss';
import test from '../../assets/test250.jpg';

function MasterclassQuizz() {
  const { quizId } = useParams();
  const history = useHistory();
  const [quiz, setQuiz] = useState(null);
  const [selectedStarted, setSelectedStarted] = useState(false);
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [answerIdx, setAnswerIdx] = useState(null);
  const [answerQuestion, setAnswerQuestion] = useState(null);
  const [correctAnswer, setCorrectAnswer] = useState('');
  const [result, setResult] = useState({
    score: 0,
    correctAnswers: 0,
    wrongAnswers: 0
  });
  const [showResult, setShowResult] = useState(false);
  const [showCorrection, setShowCorrection] = useState(false);
  const [answered, setAnswered] = useState(false);
  const [selectedAnswer, setSelectedAnswer] = useState(null);

  useEffect(() => {
    fetch(`http://localhost:8245/masterclass-quizz/${quizId}`)
      .then(response => response.json())
      .then(data => setQuiz(data))
      .catch(error => console.error(error));
  }, [quizId]);

  if (!quiz) {
    return <div>Loading...</div>;
  }

  const handleStartQuiz = () => {
    setSelectedStarted(true);
    // Start the quiz logic here, e.g., navigate to the first question
  };

  const handleCancel = () => {
    history.goBack(); // Go back to the previous page (masterclass)
  };

  const handleContinue = () => {
    setShowCorrection(false);
    setCurrentQuestion(prev => prev + 1);
  };

  if (!selectedStarted) {
    // Render the quiz title and buttons
    return (
      <div className='Quizz-home'>
        <div className="header">
          <ul className="flex justify-between">
            <li className="mr-3 pl-10 pt-5">
              <a onClick={handleCancel} className="inline-block border border-blue-500 rounded py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white" href="#">Annuler</a>
            </li>
          </ul>
        </div>
        <div className="quizz-pres">
          <img src={test} alt="test Image" />
          <h1>{quiz.name}</h1>
        </div>
        <div className="footer">
          <ul className="flex justify-end pr-10">
            <li className="mr-3 pl-10 pt-5">
              <a onClick={handleStartQuiz} className="inline-block border border-blue-500 rounded py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white" href="#">Commencer</a>
            </li>
          </ul>
        </div>
      </div>
    );
  }

  // Render the quiz questions here once it starts
  const { title, proposition, answer } = quiz.questions[currentQuestion];

  const onAnswerClick = (selectedAnswer, index) => {
    if (!answered) {
      setAnswerIdx(index);
      setAnswered(true);
      setSelectedAnswer(selectedAnswer);
      if (selectedAnswer === answer) {
        setAnswerQuestion(true);
        setCorrectAnswer(answer);
        console.log(correctAnswer);
      } else {
        setAnswerQuestion(false);
      }
    }
  };
  
  const onClickNext = () => {
    if (answered) {
      setAnswered(false);
      setAnswerIdx(null);
      setResult((prev) => {
        return answerQuestion
          ? {
              ...prev,
              score: prev.score + 5,
              correctAnswers: prev.correctAnswers + 1,
            }
          : {
              ...prev,
              wrongAnswers: prev.wrongAnswers + 1,
            };
      });
  
      if (currentQuestion !== quiz.questions.length - 1) {
        setShowCorrection(true);
      } else {
        setShowCorrection(true); // Afficher la correction de la dernière question
      }
    }
  };
  

const onClickContinue = () => {
  setShowCorrection(false);
  setCurrentQuestion(prev => prev + 1);
};

return (
  <div className="full-container">
    <div className='quizz-container'>
      {!showCorrection ? (
        <div className=''>
          <div className="header-title">
            <h2>{title}</h2>
          </div>
          <span className='active-question-no'>{currentQuestion + 1}</span>
          <span className='total-question'>/{quiz.questions.length}</span>
          <ul>
            {proposition.map((proposition, index) => {
              const isCorrectAnswer = answerIdx === index && answered && answerQuestion;
              const isSelected = answerIdx === index && !answered;
              return (
                <li
                  onClick={() => onAnswerClick(proposition, index)}
                  key={index}
                  className={isSelected ? 'button-quizz selected-answer' : 'button-quizz'}
                >
                  <span>{isCorrectAnswer ? '✓ ' : ''}{proposition}</span>
                </li>
              );
            })}
          </ul>
          <div className='footer'>
            <button onClick={onClickNext} disabled={answerIdx === null}>
              {currentQuestion === quiz.questions.length - 1 ? 'Terminé' : 'Suivant'}
            </button>
          </div>
        </div>
      ) : showCorrection && currentQuestion !== quiz.questions.length - 1 ? (
        <div className='correction'>
          <p>Bonne réponse : <span>{quiz.questions[currentQuestion].answer}</span></p>
          <button onClick={onClickContinue}>Continuer</button>
        </div>
      ) : (
        <div className='result'>
          <h3>Résultats:</h3>
          <p>Total questions : <span>{quiz.questions.length}</span></p>
          <p>Total Score : <span>{result.score}</span></p>
          <p>Bonnes réponses : <span>{result.correctAnswers}</span></p>
          <p>Mauvaises réponses : <span>{result.wrongAnswers}</span></p>
        </div>
      )}
    </div>
    <div className="gradLine3"></div>
  </div>
);
}

export default MasterclassQuizz;
