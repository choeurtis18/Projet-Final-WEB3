
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

export default QuizzList ;