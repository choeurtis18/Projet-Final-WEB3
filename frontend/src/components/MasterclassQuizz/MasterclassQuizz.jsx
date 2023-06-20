import { useState } from "react";
import { resultInitalState } from "../../constants";

const MasterclassQuizz = ({ questions }) => {
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [answerIdx, setAnswerIdx] = useState(null);
  const [answer, setAnswer] = useState(null);
  const [result, setResult] = useState(resultInitalState);
  const { question, choices, correctAnswer } = questions[currentQuestion];
  const [showResult, setShowResult] = useState(false);

  const onAnswerClick = (answer, index) => {
    setAnswerIdx(index);
    if (answer === correctAnswer) {
      setAnswer(true);
    } else {
      setAnswer(false);
    }
  };

  const onClickNext = () => {
    setAnswerIdx(null);
    setResult((prev) =>
      answer
        ? {
            ...prev,
            score: prev.score + 5,
            correctAnswers: prev.correctAnswers + 1,
          }
        : {
            ...prev,
            wrongAnswers: prev.wrongAnswers + 1,
          }
    );

    if (currentQuestion !== questions.length - 1) {
      setCurrentQuestion((prev) => prev + 1);
    } else {
      setCurrentQuestion(0);
      setShowResult(true);
    }
  };

  const onRetry = () => {
    setResult(resultInitalState);
    setShowResult(false);
  }

  return (
    <div className="quizz-container">
      {!showResult ? (
        <>
          <span className="active-question-no">{currentQuestion + 1}</span>
          <span className="total-question">/{questions.length}</span>
          <h2>{question}</h2>

          <ul>
            {choices.map((answer, index) => (
              <li
                key={answer}
                onClick={() => onAnswerClick(answer, index)}
                className={answerIdx === index ? "selected-answer" : null}
              >
                {answer}
              </li>
            ))}
          </ul>
          <div className="footer">
            <button onClick={onClickNext} disabled={answerIdx === null}>
              {currentQuestion === questions.length - 1 ? "Finish" : "Next"}
            </button>
          </div>
        </>
      ) : (
        <div className="result">
          <h3>Résultat :</h3>
          {/* Render the quiz results here */}
          <p>Nombre de questions: <span> {questions.length} </span></p>
          <p>Score: <span> {result.score} </span></p>
          <p>Bonnes réponses: <span> {result.correctAnswers} </span></p>
          <p>Mauvaises réponses: <span> {result.wrongAnswers} </span></p>
            <button onClick={onRetry}>Recommencer</button>
        </div>
      )}
    </div>
  );
};

export default MasterclassQuizz;
