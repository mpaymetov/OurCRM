import React from 'react';
import {Link, BrowserRouter} from 'react-router-dom';

export default class Nav extends React.Component {
    render() {
        return (
            <div className="container">
                <div className="navbar-inverse navbar-fixed-top navbar">
                    <ul className="navbar-nav navbar-right nav">
                        <li><Link to="/">Главная</Link></li>
                        <li><Link to="/funnels">Воронка</Link></li>
                        <li><Link to="/projects">Проекты</Link></li>
                        <li><Link to="/events">События</Link></li>
                        <li><Link to="/statisticView">Статистика</Link></li>
                    </ul>
                </div>
            </div>)
    }
}