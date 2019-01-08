import React from 'react';
import {Link, BrowserRouter}  from 'react-router-dom';

export default class Nav extends React.Component{
    render(){
        return <div>
            <Link to="/">Главная</Link>
            <Link to="/products">Товары</Link>
            <Link to="/funnels">Воронка</Link>
            <Link to="/events">События</Link>
        </div>;
    }
}