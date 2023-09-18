import React from 'react';

// Button component
const Input = ({ label, type, onChange, value, id, placeholder }) => {
  return (
    <div className='mb-4'>
      <h3 className="text-dark_primary_first text-sm font-medium mb-1">{label}</h3>
      <input className="border text-base font-light text-dark_primary_first rounded-md p-2 focus:outline-none focus:border-dark-primary-first w-full bg-lighter_primary_first" required
      type={type} id={id} onChange={onChange} value={value} placeholder={placeholder}/>
    </div>
  );
};

export default Input;