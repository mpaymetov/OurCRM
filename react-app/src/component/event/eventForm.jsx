import React, {Component} from 'react';

class EventForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            message: "",
            created: "",
            id_doer: "",
            assigment: "",
            version: "",
        };

        this.onChange = this.onChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    onChange(e) {
        console.log(e);
        var val = e.target.value;
        this.setState({message: val});
    }

    handleSubmit(e) {
        e.preventDefault();
        alert("Имя: " + this.state.message)
        console.log(this);
    }

    render() {
        return (

                <form onSubmit={this.handleSubmit}>
                    <p>
                        <label>Сообщение</label><br/>
                        <input type="text" value={this.state.message} onChange={this.onChange}/>
                    </p>
                    <p>
                        <label>Создано</label><br/>
                        <input type="text" value={this.state.created} onChange={this.onChange}/>
                    </p>
                    <p>
                        <label>Исполнитель</label><br/>
                        <input type="text" value={this.state.id_doer} onChange={this.onChange}/>
                    </p>
                    <p>
                        <label>назначение</label><br/>
                        <input type="text" value={this.state.assigment} onChange={this.onChange}/>
                    </p>
                    <p>
                        <label>назначение</label><br/>
                        <input type="text" value={this.state.version} onChange={this.onChange}/>
                    </p>
                    <input type="submit" value="Отправить"/>

                </form>

        );
    }
}

export default EventForm;
