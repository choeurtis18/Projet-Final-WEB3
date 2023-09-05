import React from 'react'
import UseAddEvent from '../../components/Event/AddEvent';

export default function AddEvent() {
    return (
        <div className='w-full p-12'>
            <h1 className="text-3xl mt-6 mb-1 font-medium text-primary_first font-black">Nouvel événement</h1>
            <UseAddEvent></UseAddEvent>
        </div>
    );
};