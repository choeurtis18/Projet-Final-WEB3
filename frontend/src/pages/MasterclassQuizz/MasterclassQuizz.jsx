import React, { useEffect, useState } from "react";
import { useParams, useHistory } from "react-router-dom";
import "./MasterclassQuizz.scss";
import logoViolet from "../../assets/Logo Violet/Logo-SRA_v2-07.png";
import AnswerTimer from "../../components/Quizz/AnswerTimer";
import test from "../../assets/test250.jpg";
import triangle from "../../assets/triangle.png";
import tambour from "../../assets/tambour.png";
import piano from "../../assets/piano.png";
import violoncelle from "../../assets/violoncelle.png";
import container1 from "../../assets/container1.png";
import { Vortex } from  'react-loader-spinner'


function MasterclassQuizz() {
  const { quizId } = useParams();
  const history = useHistory();
  const [quiz, setQuiz] = useState(null);
  const [selectedStarted, setSelectedStarted] = useState(false);
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [answerQuestion, setAnswerQuestion] = useState(null);
  const [showAnswerTimer, setShowAnswerTimer] = useState(true);
  const [result, setResult] = useState({
    score: 0,
    correctAnswers: 0,
    wrongAnswers: 0,
  });
  const [showResult, setShowResult] = useState(false);
  const [showCorrection, setShowCorrection] = useState(false);
  const [feedbackImage, setFeedbackImage] = useState(null);
  const [feedbackExpression, setFeedbackExpression] = useState(null);
  

  useEffect(() => {
    fetch(`http://localhost:8245/masterclass-quizz/${quizId}`)
      .then((response) => response.json())
      .then((data) => setQuiz(data))
      .catch((error) => console.error(error));
  }, [quizId]);

  useEffect(() => {
    if (!quiz) {
      return;
    }
    
    const { title, proposition, answer } = quiz.questions[currentQuestion];
    const percentage = (result.correctAnswers / quiz.questions.length) * 100;

    if (percentage >= 0 && percentage <= 20) {
      setFeedbackImage(triangle);
      setFeedbackExpression("Tu n'as pas toutes les cordes à ton arc.");
    } else if (percentage > 20 && percentage <= 50) {
      setFeedbackImage(tambour);
      setFeedbackExpression("Tu joues quelques notes justes, mais tu peux faire mieux.");
    } else if (percentage > 50 && percentage <= 80){
      setFeedbackImage(piano);
      setFeedbackExpression("Tu es dans la bonne tonalité, continue comme ça !");
    }
    else{
      setFeedbackImage(violoncelle);
      setFeedbackExpression("Tu es un véritable virtuose, un maestro de la musique !");
    }
  }, [currentQuestion, quiz, result.correctAnswers]);

  const handleStartQuiz = () => {
    setSelectedStarted(true);
  };

  const handleCancel = () => {
    history.goBack();
  };

  const handleContinue = () => {
    setShowCorrection(false);
    setCurrentQuestion((prev) => prev + 1);
  };

  const onAnswerClick = (selectedAnswer) => {
    setAnswerQuestion(selectedAnswer);
  };

  const onClickNext = (finalAnswer) => {
    if (answerQuestion !== null) {
      setShowAnswerTimer(false);
      setResult((prev) => {
        const isCorrectAnswer = answerQuestion === answer;
        return {
          ...prev,
          score: isCorrectAnswer ? prev.score + 5 : prev.score,
          correctAnswers: isCorrectAnswer ? prev.correctAnswers + 1 : prev.correctAnswers,
          wrongAnswers: isCorrectAnswer ? prev.wrongAnswers : prev.wrongAnswers + 1,
        };
      });

      setAnswerQuestion(null);
      console.log(quiz.questions.length );
      console.log(currentQuestion);
      console.log(currentQuestion !== quiz.questions.length );
      if (currentQuestion !== quiz.questions.length ) {
        setShowCorrection(true);
      } else {
        setShowResult(true);
      }
    }

    setTimeout(() => {
      setShowAnswerTimer(true);
    });
  };

  const onClickContinue = () => {
    setShowCorrection(false);
    setCurrentQuestion((prev) => prev + 1);
  };

  const handleEnd = () => {
    setShowCorrection(false);
    setShowResult(true);
   
  };

  const onClickBackToMasterclass = () => {
    history.push('/masterclasses');
  };


  const handleOnTimeUp = () => {
    // setAnswerQuestion(false);
    // onClickNext(false);
  };

  if (!quiz) {
    return <div className="loading-spinner">
      <Vortex
    visible={true}
    height="180"
    width="180"
    ariaLabel="vortex-loading"
    wrapperStyle={{}}
    wrapperClass="vortex-wrapper"
    colors={['#7451EB', '#F4CF74', '#231947', '#D1C4FD', '#644D15', '#9A7825']}
    />
      </div>;
  }

  if (!selectedStarted) {
    return (
      <div className="Quizz-home">
      <div className="header">
        <ul className="flex justify-between">
          <li className="mr-3 pl-10 pt-5">
            <a
              onClick={handleCancel}
              className="inline-block border border-blue-500 rounded py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white boutton-quizz"
              href="#"
            >
              Annuler
            </a>
          </li>
        </ul>
      </div>
      <div className="quizz-pres">
        <img src={test} alt="test Image" />
        <h1>{quiz.name}</h1>
      </div>
      <div className="footer-quizz pb-10 ">
        <ul className="flex justify-end pr-10">
          <li className="mr-3 pl-10 pt-5">
            <a
              onClick={handleStartQuiz}
              className="inline-block border border-blue-500 rounded py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white boutton-quizz"
              href="#"
            >
              Commencer
            </a>
          </li>
        </ul>
      </div>
    </div>
  );
  }

  const { title, proposition, answer, xp_value } = quiz.questions[currentQuestion];
  return (
    <div className="full-container-quizz">
      <nav>
        {showAnswerTimer && !showCorrection && !showResult && (
          <AnswerTimer duration={10} onTimeUp={handleOnTimeUp} />
        )}
      </nav>
  
      <div className="headerQuizz">
        <div>
          <button className="bg-primary_second hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-28 h-100">
            {currentQuestion + 1}/{quiz.questions.length}
          </button>
        </div>
        <div className="header-title">
        <div className="headerQuizz">
        {showResult ? (
          <h2>Résultat</h2>
        ) : showCorrection ? (
          <h2>Correction</h2>
        ) : (
          <h2>{title}</h2>
        )}
          </div>
        </div>
        <div className="header-counter">
        {!showCorrection && !showResult && (
          <button className="bg-primary_second hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Button
          </button>
        )}
        </div>
      </div>
  
      <div className="quizz-container">
        {showResult ? (
          <div className="container-result">
            <div className="quizz-container-container">
              {/*<span className='active-question-no'>{currentQuestion + 1}</span>
            <span className='total-question'>/{quiz.questions.length}</span> */}
              <div className="image-quizz">
                <img src={feedbackImage} alt="triangle instrument" />
              </div>
              <div className="liste-reponse">
                <button className="button-quizz-summary button-quizz  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                  <span>
                    {result.correctAnswers}/{quiz.questions.length}
                  </span>
                  <p>bonnes réponses</p>
          
                </button>
      
              </div>
              
            </div>
            <div className="phrase-conclusion"> <p>{feedbackExpression}</p></div>
            
            </div>
        ) : ! showCorrection ? (
          <div className="quizz-container-container">
            {/*<span className='active-question-no'>{currentQuestion + 1}</span>
            <span className='total-question'>/{quiz.questions.length}</span> */}
            <div className="image-quizz">
              <img src={logoViolet} alt="" />
            </div>
            <div className="liste-reponse">
              <ul>
                {proposition.map((proposition, index) => (
                  <li
                    onClick={() => onAnswerClick(proposition)}
                    key={index}
                    className={
                      answerQuestion === proposition
                        ? "button-quizz selected-answer"
                        : "button-quizz"
                    }
                  >
                    <span>{proposition}</span>
                  </li>
                ))}
              </ul>
            </div>
  
            {/* <div className='footer'>
              <button onClick={onClickNext} disabled={answerQuestion === null}>
                {currentQuestion === quiz.questions.length - 1 ? 'Terminé' : 'Poursuivre'}
              </button>
            </div> */}
          </div>
        ) : (
          <div className="quizz-container-container">
            {/*<span className='active-question-no'>{currentQuestion + 1}</span>
            <span className='total-question'>/{quiz.questions.length}</span> */}
            <div className="image-quizz">
              <img src={container1} alt="image quizz " />
            </div>
            <div className="liste-reponse">
              <ul className="ul-correction">
                <li className="button-quizz button-correction" disabled>
                  <span>{quiz.questions[currentQuestion].answer}</span>
                </li>
              </ul>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
                efficitur sodales turpis quis scelerisque. Pellentesque iaculis
                ante ut nisl lobortis, nec volutpat justo blandit. Proin
                efficitur tincidunt nisl, sit amet suscipit purus bibendum a.
                Nullam ornare nulla eu leo facilisis vehicula. Curabitur arcu
                libero, sollicitudin quis vulputate non, bibendum a justo.
                Praesent porttitor justo nec consectetur luctus. Morbi convallis
                eget ipsum ac fringilla. Suspendisse sed elit sit amet diam
                auctor sollicitudin eget vel nisi. Proin sit amet ante tortor.
              </p>
            </div>
                  </div>
        )}
      </div>
  
      <div className="footerQuizz">
        <div className="gradLine3"></div>
            
        <div className="buttonContainer">
          <button className="centerButton bg-primary_second hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
            
            🎻 {xp_value} Xp
          </button>
        </div>
        <div className="button-footer">
          <div></div>
          <div></div>
          <div>
          {showResult ? (
  <button
    className="bg-primary_first hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    onClick={onClickBackToMasterclass}
  >
    Revenir à la liste des masterclass
  </button>
) : (
  showCorrection ? (
    currentQuestion !== quiz.questions.length - 1 ? (
      <button
        className="bg-primary_first hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        onClick={onClickContinue}
      >
        Continuer
      </button>
    ) : (
      <button
        className="bg-primary_first hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        onClick={handleEnd}
      >
        Terminé
      </button>
    )
  ) : (
    <button
      className="bg-primary_first hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      onClick={() => onClickNext(answer)}
      disabled={answerQuestion === null}
    >
      Poursuivre
    </button>
  )
)}

  
          </div>
        </div>    </div>
    </div>
  );
  
  }

export default MasterclassQuizz;
