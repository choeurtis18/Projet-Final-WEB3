import React from 'react';

const MasterclassQuizz = ({ masterclass }) => {
  console.log(masterclass);

  return (
    <div>
      <h2>{masterclass.title}</h2>
      <h2>{masterclass.description}</h2>
      <h2>{masterclass.certification}</h2>


    </div>
  );
};


export default MasterclassQuizz;