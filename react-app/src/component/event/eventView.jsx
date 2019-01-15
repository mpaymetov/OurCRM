import React, {Component} from 'react';

class EventView extends Component {
    constructor(props) {
        super(props);
        this.state = this.props;
    }

    render() {
        console.log(this.state);
        return   <div className="form_wrap panel view_panel">
            <div className="inner_form">
                <form onSubmit={this.handleSubmit}>
                    <p>
                        <label>Сообщение</label><br/>
                        <input type="text" className="form-control" value={this.state.message}/>
                    </p>
                    <p>
                        <label>Создано</label><br/>
                        <input type="text" className="form-control" value={this.state.created}/>
                    </p>
                    <p>
                        <label>Исполнитель</label><br/>
                        <input type="text" className="form-control" value={this.state.id_doer}/>
                    </p>
                    <p>
                        <label>назначение</label><br/>
                        <input type='text' className="datepicker-here form-control" data-timepicker="true"
                               data-position="right top"/>
                    </p>
                    <p>
                        <label>версия</label><br/>
                        <input type="text" className="form-control" value={this.state.version}/>
                    </p>
                    <input type="submit" value="Изменить"/>
                    <input type="submit" value="Удалить"/>

                </form>
            </div>
        </div>
    }
}
export default EventView;
