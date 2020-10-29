import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { MatTableModule } from "@angular/material/table";
import { ServersComponent } from './servers/servers.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MatFormFieldControl, MatFormFieldModule} from "@angular/material/form-field";
import {ApiService} from "./shared/services/api.service";
import {HttpClientModule} from "@angular/common/http";
import {MatSelectModule} from "@angular/material/select";
import {FormsModule} from "@angular/forms";

@NgModule({
  declarations: [
    AppComponent,
    ServersComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
      MatTableModule,
      MatFormFieldModule,
      HttpClientModule,
      MatSelectModule,
      FormsModule
  ],
  providers: [ ApiService ],
  bootstrap: [AppComponent]
})


export class AppModule { }
