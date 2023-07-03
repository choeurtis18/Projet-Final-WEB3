import React, { useEffect, useState } from 'react';
import MasterclassQuizz from '../MasterclassQuizz/MasterclassQuizz';

function Homepage() {
  const [masterclasses, setMasterclasses] = useState([]);
  const [selectedMasterclass, setSelectedMasterclass] = useState(null);

  useEffect(() => {
    fetch('http://localhost:8245/masterclassesjson')
      .then(response => response.json())
      .then(data => setMasterclasses(data))
      .catch(error => console.error(error));
  }, []);

  const handleMasterclassSelection = (masterclass) => {
    setSelectedMasterclass(masterclass);
  };

  return (
    <div>
      <h1>List of Masterclasses</h1>
      {selectedMasterclass ? (
        <MasterclassQuizz masterclass={selectedMasterclass} />
      ) : (
        <ul>
          {masterclasses.map(masterclass => (
            <li key={masterclass.id} onClick={() => handleMasterclassSelection(masterclass)}>
              {masterclass.title}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

export default Homepage;
