import React, { useEffect, useState } from 'react';

const MasterclassQuizz = () => {
  const [masterclassQuizzs, setMasterclassQuizzs] = useState([]);
  const [selectedQuizz, setSelectedQuizz] = useState(null);

  useEffect(() => {
    fetchMasterclassQuizzs();
  }, []);

  const fetchMasterclassQuizzs = async () => {
    try {
      const response = await fetch('/masterclass-quizz');
      const data = await response.json();
      setMasterclassQuizzs(data);
    } catch (error) {
      console.error('Error fetching masterclassQuizzs:', error);
    }
  };

  const handleQuizzSelection = (quizz) => {
    setSelectedQuizz(quizz);
  };

  return (
    <div>
      <h1>Masterclass Quizzs</h1>
      {selectedQuizz ? (
        <QuizzDetails quizz={selectedQuizz} />
      ) : (
        <QuizzList
          masterclassQuizzs={masterclassQuizzs}
          onSelectQuizz={handleQuizzSelection}
        />
      )}
    </div>
  );
};

const QuizzList = ({ masterclassQuizzs, onSelectQuizz }) => {
  return (
    <div>
      {masterclassQuizzs.map((quizz) => (
        <div key={quizz.id}>
          <h2>{quizz.name}</h2>
          <p>Counter: {quizz.counter}</p>
          <button onClick={() => onSelectQuizz(quizz)}>Start Quizz</button>
        </div>
      ))}
    </div>
  );
};

const QuizzDetails = ({ quizz }) => {
  const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);

  const handleNextQuestion = () => {
    setCurrentQuestionIndex((prevIndex) => prevIndex + 1);
  };

  const currentQuestion = quizz.questions[currentQuestionIndex];

  return (
    <div>
      <h2>{quizz.name}</h2>
      <p>Counter: {quizz.counter}</p>
      <h3>Question {currentQuestionIndex + 1}</h3>
      <p>Title: {currentQuestion.title}</p>
      <p>Answer: {currentQuestion.answer}</p>
      <p>XP Value: {currentQuestion.xp_value}</p>
      <p>Proposition: {currentQuestion.proposition.join(', ')}</p>
      {currentQuestionIndex < quizz.questions.length - 1 ? (
        <button onClick={handleNextQuestion}>Next Question</button>
      ) : (
        <p>End of Quizz</p>
      )}
    </div>
  );
};

export default MasterclassQuizz;
