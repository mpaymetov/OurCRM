import React, {Component} from 'react';

class topMenu extends Component {

    render() {
        return (
            <nav id="w6" className="navbar-inverse navbar-fixed-top navbar">
                <div className="container">
                    <div className="navbar-header">
                        <a className="navbar-brand" href="/web/">My Application</a></div>
                    <div id="w6-collapse" className="collapse navbar-collapse">
                        <ul id="w7" className="navbar-nav navbar-right nav">
                            <li><a href="/web/index.php?r=item%2Findex">Items</a></li>
                            <li><a href="/web/index.php?r=client%2Findex">Клиент</a></li>
                            <li><a href="/web/index.php?r=project%2Findex">Проект</a></li>
                            <li><a href="/web/index.php?r=events-not-complited%2Findex">Not complited</a></li>
                            <li><a href="/web/index.php?r=department%2Findex">Отдел</a></li>
                            <li><a href="/web/index.php?r=service%2Findex">Услуга</a></li>
                            <li><a href="/web/index.php?r=event%2Findex">Событие</a></li>
                            <li><a href="/web/index.php?r=statistic%2Findex">Статистика</a></li>
                            <li><a href="/web/index.php?r=user%2Findex">Пользователи</a></li>
                            <li>
                                <form action="/web/index.php?r=user%2Flogout" method="post">
                                    <input type="hidden" name="_csrf"
                                           value="qRMKVT6onqOEIwi7MeX0Cl1BQGFrSVzVvOlNsbxT2z35Yms8WZnc5etvYO1Fq8N_Oww4MCktA6CJrRv90wKXag=="/>
                                        <button type="submit" className="btn btn-link logout">Выход (admin)</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
}

export default topMenu;