import React from 'react'
import UseUpdateEvent from "../../Hook/useUpdateEvent";

export default function AddEvent() {
    return (
        <div>
            <h1 className="text-center">Mettre à jour l'événement </h1>
            <UseUpdateEvent></UseUpdateEvent>
        </div>
    );
}; 