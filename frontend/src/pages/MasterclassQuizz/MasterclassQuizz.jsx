// QuizDetails.js
import React, { useEffect, useState } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import './MasterclassQuizz.scss';
import test from "../../assets/test250.jpg";

function MasterclassQuizz() {
  const { quizId } = useParams();
  const history = useHistory();
  const [quiz, setQuiz] = useState(null);
  const [selectedStarted, setSelectedStarted] = useState(false);
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [answerIdx, setAnswerIdx] = useState(null);
  const [answerQuestion, setAnswerQuestion] = useState(null);
  const resultInitialState = {
    score: 0,
    correctAnswers: 0,
    wrongAnswers: 0
  };
  const [result, setResult] = useState(resultInitialState);
  const [showResult, setShowResult] = useState(false);

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
    setAnswerIdx(index);
    if (selectedAnswer === answer) {
      setAnswerQuestion(true);
      setResult((prev) => ({
        ...prev,
        score: prev.score + 5,
        correctAnswers: prev.correctAnswers + 1
      }));
    } else {
      setAnswerQuestion(false);
      setResult((prev) => ({
        ...prev,
        wrongAnswers: prev.wrongAnswers + 1
      }));
    }
  };

  const onClickNext = () => {
    setAnswerIdx(null);
    if (currentQuestion !== quiz.questions.length - 1) {
      setCurrentQuestion((prev) => prev + 1);
    } else {
      setCurrentQuestion(0);
      setShowResult(true);
    }
  };

  return (
    <div className='quizz-container'>
      {!showResult ? (
        <div>
          <span className='active-question-no'>{currentQuestion + 1}</span>
          <span className='total-question'>/{quiz.questions.length}</span>
          <h2>{title}</h2>
          <ul>
            {proposition.map((proposition, index) => (
              <li
                onClick={() => onAnswerClick(proposition, index)}
                key={index}
                className={answerIdx === index ? 'selected-answer' : null}
              >
                {proposition}
              </li>
            ))}
          </ul>
          {answerIdx !== null && (
            <div className="feedback">
              {answerQuestion ? <p className="correct">Bonne réponse !</p> : <p className="wrong">Mauvaise réponse.</p>}
              <button onClick={onClickNext}>Suivant</button>
            </div>
          )}
        </div>
      ) : (
        <div className='result'>
          <h3>Resultats:</h3>
          <p>Total questions : <span>{quiz.questions.length}</span></p>
          <p>Total Score : <span>{result.score}</span></p>
          <p>Bonnes réponses : <span>{result.correctAnswers}</span></p>
          <p>Mauvaises réponses : <span>{result.wrongAnswers}</span></p>
        </div>
      )}
    </div>
  );
}

export default MasterclassQuizz;
