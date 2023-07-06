// MasterclassDetails.js

import React, { useEffect, useState } from 'react';
import { useParams, Link} from 'react-router-dom';

function MasterclassDetails() {
  const { id } = useParams();
  const [masterclass, setMasterclass] = useState(null);

  useEffect(() => {
    fetch(`http://localhost:8245/masterclassjson/${id}`)
      .then(response => response.json())
      .then(data => setMasterclass(data))
      .catch(error => console.error(error));
  }, [id]);

  if (!masterclass) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      
      <h1>{masterclass.title}</h1>
      <p>{masterclass.description}</p>
      {/* Display other masterclass details as needed */}
      {masterclass.quizzes.map(quizz => (
        <div key={quizz.id}>
        <Link to={`/masterclassQuizz/${quizz.id}`}>

          <h3>{quizz.name}</h3>
        </Link>
          <p>{quizz.description}</p>
          <Link to={`/masterclassQuizz/${quizz.id}`}>Commencer le quizz</Link>
        </div>
      ))}
    </div>
  );
}

export default MasterclassDetails;
