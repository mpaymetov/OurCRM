import React, {Component} from 'react'

class createServicesetForm extends Component{

    constructor(props) {
        super(props);
        this.state = { values: [] };
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    createUI(){
        return this.state.values.map((el, i) =>
            <div key={i} className="form-group">
                <div className={"col-sm-10"}>
                <input type="text" value={el||''} className={"form-control"} onChange={this.handleChange.bind(this, i)} />
                </div>
                <div className="col-sm-2">
                <a className={"glyphicon glyphicon-remove btn btn-default"} onClick={this.removeClick.bind(this, i)}/>
                </div>
            </div>
        )
    }

    handleChange(i, event) {
        let values = [...this.state.values];
        values[i] = event.target.value;
        this.setState({ values });
    }

    addClick(){
        this.setState(prevState => ({ values: [...prevState.values, '']}))
    }

    removeClick(i){
        let values = [...this.state.values];
        values.splice(i,1);
        this.setState({ values });
    }

    handleSubmit(event) {
        alert('A name was submitted: ' + this.state.values.join(', '));
        console.log(this.state.values);
        event.preventDefault();
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <h3 className="col-sm-12">Создать пакет услуг</h3>
                <div>
                    <label className={"col-sm-10"}>Услуга</label>
                    <div class="col-sm-2">
                    <a className={"glyphicon glyphicon-plus btn btn-default"} onClick={this.addClick.bind(this)}/>
                    </div>
                </div>
                {this.createUI()}
                <div className={"col-sm-12"}>
                <input  type="submit" class="btn btn-default" value="Создать" />
                </div>
            </form>
        );
    }

}

export default createServicesetForm