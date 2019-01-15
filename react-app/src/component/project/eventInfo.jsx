import React, {Component} from 'react';
import {BrowserRouter, Route, Switch, Link, NavLink} from 'react-router-dom';

class EventInfo extends Component {

    render() {
        return (
            <div className="panel-body post panel">
                <div className="col-md-6">
                    <h5>Событие</h5>
                    <p>{this.props.eventInfo.message}</p>
                    <p>Дата создания {this.props.eventInfo.created}</p>
                    <p>Дата выполнения {this.props.eventInfo.assignment}</p>
                    <nav>
                        <Link
                            to={"/eventsView/" + this.props.eventInfo.id_event}> подробнее </Link>
                    </nav>
                </div>
            </div>

        )
            ;
    }

}

export default EventInfo;