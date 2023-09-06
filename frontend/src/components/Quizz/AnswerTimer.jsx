import React, { useEffect, useRef, useState } from 'react';
import './Quizz.scss';

function AnswerTimer({ duration, onTimeUp }) {
  const [counter, setCounter] = useState(0);
  const [progressLoaded, setProgressLoaded] = useState(0);
  const intervalRef = useRef();

  useEffect(() => {
    intervalRef.current = setInterval(() => {
      setCounter((cur) => cur + 1);
    }, 1000);

    return () => clearInterval(intervalRef.current);
  }, []);

  useEffect(() => {
    setProgressLoaded(100 * (counter / duration));

    if (counter === duration) {
      clearInterval(intervalRef.current);

      setTimeout(() => {
        onTimeUp();
      }, 1000);
    }
  }, [counter, duration, onTimeUp]);

  return (
    <div className="progress-bar">
    <div style={{ width: `${progressLoaded}%` , backgroundColor:`${progressLoaded <70 ? "#F4CF74" :  "red"}` }}className="progress-bar--step progress-bar--animate">{counter}</div>
    </div>
  );
}

export default AnswerTimer;
