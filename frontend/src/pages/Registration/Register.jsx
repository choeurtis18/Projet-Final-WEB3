import React from 'react'
import RegisterForm from '../../components/Register/RegisterForm'

export default function Register() {
  return (
    <div>
      <div className="flex min-h-full">
        <div className="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
          <div className="mx-auto w-full max-w-sm lg:w-96">
            <div className=''>
              <p className="mt-8 text-sm leading-6 text-gray-500">
                SALINE ROYAL ACADEMY
              </p>
              <h2 className="mt-2 text-[2.5rem] font-bold leading-9 tracking-tight text-gray-900">Inscrivez-vous ! </h2>
              <p className="mt-6 text-sm leading-6 text-gray-500">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam dolor animi consectetur. Provident illum, minus odit  
              </p>
            </div>

            <div className="mt-10">
              <div>
                <RegisterForm/>
              </div>
            </div>
          </div>
        </div>
        <div className="relative hidden w-0 flex-1 lg:block">
          <img className="absolute inset-0 h-screen w-full object-cover" src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjJ8fGluc3RydW1lbnR8ZW58MHwwfDB8fHww&auto=format&fit=crop&w=500&q=60" alt=""/>
        </div>
      </div>
    </div>
  )
}
