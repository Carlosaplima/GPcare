Imports system.io
Public Class roteiros
    Dim rots() As String
    Private Sub roteiros_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        pegaquestoes()
        atualizalista()
        aturot()
    End Sub
    Sub aturot()
        'popula rots
        If File.Exists(pastaPesq & "\" & arquivo & ".cfg") Then
            Dim obj As StreamReader = New StreamReader(pastaPesq & "\" & arquivo & ".cfg")
            ListBox3.Items.Clear()
            Do While obj.Peek <> -1
                Dim linha As String = obj.ReadLine
                Dim kk() As String = linha.Split("|")
                rots(kk(0)) = linha
                ListBox3.Items.Add(linha)
            Loop
            obj.Close()
        End If

    End Sub
    Sub atualizalista()
        ListBox1.Items.Clear()
        ComboBox1.Items.Clear()
        ComboBox1.Items.Add("")
        For i As Integer = 0 To quests
            Dim opa As String = ""
            Dim jjj As String = questoes(i)
            Dim jj() As String = jjj.Split("|")
            ListBox1.Items.Add(jj(0) & "-" & jj(1))
            ComboBox1.Items.Add(jj(1))

        Next

        ReDim rots(quests)
    End Sub


    Private Sub ListBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox1.SelectedIndexChanged
        ' antes de exibir verifica se é multi se não for, da mensagem de erro
        If Not ListBox1.SelectedItem Is Nothing Then  Else Exit Sub
        If ListBox1.SelectedItem.ToString.ToLower.StartsWith("multipla escolha") Then
        Else
            MsgBox("Roteiros só são permitidos em Respostas de Multipla Escolha")
            ListBox2.DataSource = Nothing
            ComboBox1.Text = ""
            ListBox1.SelectedItem = Nothing
            Exit Sub
        End If

        exibeopcoes(ListBox1.SelectedIndex)
    End Sub
    Sub exibeopcoes(ByVal qual As Integer)
        'Multipla Escolha|Quantas vezes?|1¨2¨3¨4¨5¨6¨7¨8
        ListBox2.DataSource = Nothing
        Dim jjj As String = questoes(qual)
        Dim jj() As String = jjj.Split("|")
        Dim kk() As String = jj(2).Split("¨")
        ListBox2.DataSource = kk
    End Sub

    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button5.Click
        Me.Close()
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        ' salva a opção
        If ListBox1.SelectedIndex >= 0 Then  Else MsgBox("selecione a questão") : Exit Sub
        If ListBox2.SelectedIndex >= 0 Then  Else MsgBox("selecione a Alternativa") : Exit Sub
        If ComboBox1.SelectedIndex >= 0 Then  Else MsgBox("selecione a nova questão") : Exit Sub

        ' verifica se ja tem
        ' ja existe

        If Not rots(ListBox1.SelectedIndex) Is Nothing Then
            ' tem valores, então apaga e reconstroi
            Dim hh() As String = rots(ListBox1.SelectedIndex).Split("|")
            rots(ListBox1.SelectedIndex) = Nothing
            Dim obs As String = ""
            Dim inc As Boolean = True
            For i As Integer = 1 To UBound(hh) - 1
                If hh(i).StartsWith(ListBox2.SelectedIndex & ";") Then
                    If ComboBox1.SelectedIndex = 0 Then
                        ' estou apagando
                        inc = False
                        Continue For
                    End If
                    ' troquei
                    inc = False
                    obs &= ListBox2.SelectedIndex & ";" & ComboBox1.SelectedIndex & "|"
                Else
                    obs &= hh(i) & "|"
                End If
            Next
            If obs = "" Then
                ' nao achou o maledito, então inclui
                rots(ListBox1.SelectedIndex) &= ListBox1.SelectedIndex & "|" & ListBox2.SelectedIndex & ";" & ComboBox1.SelectedIndex & "|"
            Else
                rots(ListBox1.SelectedIndex) = ListBox1.SelectedIndex & "|" & obs
                If inc Then rots(ListBox1.SelectedIndex) &= ListBox2.SelectedIndex & ";" & ComboBox1.SelectedIndex & "|"
            End If


        Else
            ' nao tinha nada
            rots(ListBox1.SelectedIndex) &= ListBox1.SelectedIndex & "|" & ListBox2.SelectedIndex & ";" & ComboBox1.SelectedIndex & "|"
        End If



        ' ListBox3.Items.Clear()
        ' atualiza a linha do list contendo o listbox1.seletecindex
        Dim salva As Integer = 0
        For i As Integer = 0 To ListBox3.Items.Count - 1
            Dim gg() As String = ListBox3.Items.Item(i).ToString.Split("|")
            If gg(0) = ListBox1.SelectedIndex Then
                ' achou
                ListBox3.Items.RemoveAt(i)
                salva = i
                Exit For
            End If
        Next
        If salva > -1 Then
            ListBox3.Items.Insert(salva, rots(ListBox1.SelectedIndex).ToString)
        Else
            ListBox3.Items.Add(rots(ListBox1.SelectedIndex).ToString)
        End If
    End Sub

    Private Sub ListBox2_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox2.SelectedIndexChanged
        ' verifica se tem destino e coloca, senão zera o texto do combo

        Dim achou As Boolean = False
        If Not rots(ListBox1.SelectedIndex) Is Nothing Then
            Dim hh() As String = rots(ListBox1.SelectedIndex).Split("|")
            For i As Integer = 0 To UBound(hh) - 1
                If hh(i).StartsWith(ListBox2.SelectedIndex & ";") Then
                    achou = True
                    Dim jk() As String = hh(i).Split(";")
                    ComboBox1.SelectedIndex = jk(1)
                    Exit For
                End If
            Next
        End If
        If Not achou Then ComboBox1.Text = ""
    End Sub

    Private Sub ComboBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ComboBox1.SelectedIndexChanged
        If ComboBox1.Text <> "" Then Button3_Click(sender, e)
    End Sub

    Private Sub Button7_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button7.Click
        'salva listbox em um txt
        Dim obj As StreamWriter = New StreamWriter(pastaPesq & "\" & arquivo & ".cfg", False, System.Text.Encoding.Unicode)
        For i As Integer = 0 To ListBox3.Items.Count - 1
            obj.WriteLine(ListBox3.Items.Item(i).ToString)
        Next
        obj.Close()
        MsgBox("Roteiros salvos")
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        If MsgBox("Remover todos os roteiros?", MsgBoxStyle.YesNo) <> MsgBoxResult.Yes Then Exit Sub
        ReDim rots(quests)
        ListBox3.Items.Clear()
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)

    End Sub

    Private Sub Button1_Click_1(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        If ListBox1.SelectedIndex <> -1 Then
            If MsgBox("Atenção, essa operação ira remover os roteiros para a questão: " & ListBox1.SelectedItem & " Confirma?", MsgBoxStyle.YesNo) <> MsgBoxResult.Yes Then Exit Sub
            rots(ListBox1.SelectedIndex) = Nothing
            Exit Sub
        Else
            MsgBox("Selecione a questão para remover mapeamentos.")
        End If

    End Sub
End Class

Imports System.IO
Public Class param
    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button5.Click
        ' salva questoes em txt
        If MsgBox("Confirma Salvar a Pesquisa?", MsgBoxStyle.YesNo) <> MsgBoxResult.Yes Then Exit Sub

        If tipo = "nova" Then
            If t_pesq.Text <> "" Then
                arquivo = t_pesq.Text & ".txt"
                tipo = "edita"
            Else
                MsgBox("Informe o nome da Pesquisa.")
                t_pesq.Focus()
                Exit Sub
            End If
        End If
        tabmod = t_pesq.Text.ToLower.Replace(".txt", "")
        tabmod = limpamodulo()

        Dim jj As StreamWriter = New StreamWriter(pastaPesq & "\" & arquivo, False, System.Text.Encoding.Unicode)
        For i As Integer = 0 To quests
            jj.WriteLine(questoes(i))
        Next
        jj.Close()
        MsgBox("Pesquisa salva.")
        criabase()
        pegaquestoes()
        atualizalista()
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        'cria uma nova questão
        quests += 1
        Dim obj As New questao
        obj.indice = quests
        obj.ShowDialog()
        If obj.indice = -1 Then quests = quests - 1 'ou seja não salvou
        'pegaquestoes()
        atualizalista()
    End Sub

    Private Sub param_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        ' pega questões
        If tipo = "nova" Then
            arquivo = ""
        End If
        t_pesq.Text = arquivo
        If t_pesq.Text <> "" Then t_pesq.ReadOnly = True Else t_pesq.ReadOnly = False
        questoes = New ArrayList
        If tipo = "edita" Then
            pegaquestoes()
            atualizalista()
        Else
            quests = -1
        End If

    End Sub
    
    Sub atualizalista()
        ListBox1.Items.Clear()
        For i As Integer = 0 To quests
            Dim opa As String = ""
            Dim jjj As String = questoes(i)
            Dim jj() As String = jjj.Split("|")
            'ListBox1.Items.Add(jj(0) & "-" & jj(1))

            ListBox1.Items.Add(jj(0) & "-" & jj(1))

        Next
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        If ListBox1.SelectedItem <> "" Then  Else MsgBox("Selecione o item") : Exit Sub
        If MsgBox("Confirma remover questão?", MsgBoxStyle.YesNo) <> MsgBoxResult.Yes Then Exit Sub
        questoes.RemoveAt(ListBox1.SelectedIndex)
        quests = quests - 1
        'pegaquestoes()
        atualizalista()
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        If ListBox1.SelectedItem <> "" Then  Else MsgBox("Selecione o item") : Exit Sub
        Dim obj As New questao
        obj.indice = ListBox1.SelectedIndex
        obj.questinha = questoes(ListBox1.SelectedIndex)
        obj.ShowDialog()
        'pegaquestoes()
        atualizalista()

    End Sub

    Private Sub Button6_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button6.Click
        If ListBox1.SelectedItem <> "" Then  Else MsgBox("Selecione a questão.") : Exit Sub
        If ListBox1.SelectedIndex > 0 Then  Else Exit Sub
        Dim old As String = questoes(ListBox1.SelectedIndex)
        questoes.RemoveAt(ListBox1.SelectedIndex)
        questoes.Insert(ListBox1.SelectedIndex - 1, old)
        Dim kk As Integer = ListBox1.SelectedIndex - 1
        atualizalista()
        ListBox1.SelectedIndex = kk
    End Sub

    Private Sub Button8_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button8.Click
        If ListBox1.SelectedItem <> "" Then  Else MsgBox("Selecione a questão.") : Exit Sub
        If ListBox1.SelectedIndex < questoes.Count - 1 Then  Else Exit Sub
        Dim old As String = questoes(ListBox1.SelectedIndex)
        questoes.RemoveAt(ListBox1.SelectedIndex)
        questoes.Insert(ListBox1.SelectedIndex + 1, old)
        Dim kk As Integer = ListBox1.SelectedIndex + 1
        atualizalista()
        ListBox1.SelectedIndex = kk
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        Me.Close()
    End Sub

    Private Sub Button7_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button7.Click
        Dim obj As New roteiros
        obj.ShowDialog()
    End Sub

    Private Sub Button9_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button9.Click
        Dim obj As New avls
        obj.ShowDialog()
    End Sub
End Class


Imports System.Data.SqlServerCe
Imports System.data
Imports System.io
Public Class aplic
    Dim pode As Boolean = False
    Dim _indice As Integer = 0
    Dim _tipo As String = ""
    Dim _pergunta As String = ""
    Dim _resp As String = ""
    Dim _sep As String = ""
    Dim resps() As String
    Dim rexps() As String
    Dim _com As SqlCeCommand
    Dim _con As SqlCeConnection
    Dim pos As Integer = 0
    Dim iddados As Integer = 0
    Dim _id As Integer = 0
    Dim direcao As String = ""
    Dim roteiro() As String
    Dim acentua As String = ""
    Dim outros As Boolean = False
    Dim dist As Integer = 50
    Dim pps(6) As String '= {"Péssimo", "Ruim", "Regular", "Bom", "Ótimo", "N/A"}
    Public Property xid() As Integer
        Get
            xid = _id
        End Get
        Set(ByVal value As Integer)
            _id = value
        End Set
    End Property
    Private Sub aplic_Closing(ByVal sender As Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles MyBase.Closing
        Try
            _con.Close()
        Catch ex As Exception

        End Try
        Try
            _com.Dispose()

        Catch ex As Exception

        End Try
        Try
            _con.Dispose()
        Catch ex As Exception

        End Try

    End Sub
    Sub pegaavaliacao()
        If File.Exists(pasta & "\pesq\" & modulo & ".txt.avl") Then
            Dim avl As StreamReader = New StreamReader(pasta & "\pesq\" & modulo & ".txt.avl")
            Try
                For i As Integer = 0 To 5
                    pps(i) = avl.ReadLine
                Next
            Catch ex As Exception
                MsgBox("Erro no arquivo de Avaliações, carregando defaults.")
                pps(0) = "Péssimo"
                pps(1) = "Ruim"
                pps(2) = "Regular"
                pps(3) = "Bom"
                pps(4) = "Ótimo"
                pps(5) = "N/A"
            End Try
            
            
            avl.Close()
        Else
            ' nao tem, poe default
            pps(0) = "Péssimo"
            pps(1) = "Ruim"
            pps(2) = "Regular"
            pps(3) = "Bom"
            pps(4) = "Ótimo"
            pps(5) = "N/A"
        End If

    End Sub
    Private Sub aplic_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

        Me.Text = "Pesquisa: " & modulo
        arquivo = modulo & ".txt"

        tabmod = modulo
        tabmod = limpamodulo()

        pegaavaliacao()

        c_resposta.Visible = False
        b_resposta.Visible = False
        tecrado.Visible = False
        tecrado.Location = New Point(1, 1)
        Panel1.Visible = False

        Panel1.Location = New Point(72, 21)

        pegaquestoes()



        'abre conexão para o sqlce
        _con = New SqlCeConnection("data Source =" & pasta & "\banco.sdf")
        _com = _con.CreateCommand()
        _con.Open()


        vai()
    End Sub
    Sub vai()
        If quests = -1 Then MsgBox("Não existem questões configuradas") : Me.Close() : Exit Sub

        ReDim resps(quests)
        ReDim rexps(quests)
        ReDim roteiro(quests)

        enchebco()

        If _id > 0 Then
            ' pega respostas
            pegarespostas()
            _indice = 0
        End If

        pegaroteiro()
        monta()
        mostraresp()

    End Sub
    Sub pegaroteiro()
        If File.Exists(pasta & "\pesq\" & arquivo & ".cfg") Then
            Dim obj As StreamReader = New StreamReader(pasta & "\pesq\" & arquivo & ".cfg", System.Text.Encoding.Default)
            Do While obj.Peek <> -1
                Dim linha As String = obj.ReadLine
                Dim kk() As String = linha.Split("|")
                roteiro(kk(0)) = linha
            Loop
            obj.Close()
        End If
    End Sub
    Sub monta()
        Label2.Text = _indice & vbCrLf & quests
        outros = False
        If _indice = questoes.Count - 1 Then
            Button1.Font = New System.Drawing.Font("Tahoma", 18.0!, System.Drawing.FontStyle.Bold)
            Button1.Text = "OK"
        Else
            Button1.Font = New System.Drawing.Font("Wingdings", 18.0!, System.Drawing.FontStyle.Bold)
            Button1.Text = "è"
        End If

        l_p.Visible = False
        Panel2.Visible = False
        t_resposta.Visible = False
        l_resposta.Visible = False
        b_resposta.Visible = False
        c_resposta.Visible = False
        pode = False

        Dim ob() As String = questoes(_indice).ToString.Split("|")
        _tipo = ob(0)
        _pergunta = ob(1)
        If ob(0) <> "Resposta Simples" Then
            t_resposta.Text = ""
            'quebra as respostas
            'Dim jj() As String = ob(2).Split("¨")
            _resp = ob(2)
            'For i As Integer = 0 To UBound(jj)
            '_resp &= jj(i) & vbCrLf
            ' Next
            Try
                If _tipo = "Varias Escolhas" Then _sep = ob(3)
            Catch ex As Exception

            End Try

        End If



        l_pergunta.Text = _pergunta
        l_tipo.Text = _tipo

        Button6.Visible = False
        Button7.Visible = False
        Button50.Visible = False
        Button11.Visible = False

        If _tipo = "Resposta Simples" Then
            Button6.Visible = True
            Button7.Visible = True
            Button50.Visible = True
            Button11.Visible = True
            t_resposta.Visible = True
            l_resposta.Visible = False
            l_resposta.Controls.Clear()
        ElseIf _tipo = "Multipla Escolha" Or _tipo = "Varias Escolhas" Then
            t_resposta.Visible = False
            l_resposta.Visible = True
            l_resposta.Controls.Clear()
            l_resposta.Location = New Point(0, 69)
            ' pega as respostas
            Dim oo() As String = _resp.Split("¨")
            Dim tp As String = _tipo.Substring(0, 1)
            ' coloca as opções

            l_resposta.Controls.Clear()
            Dim linha As Integer = 10

            For i As Integer = 0 To UBound(oo)
                If oo(i) = "" Then Continue For
                If tp = "M" Then
                    ' adiciona radio
                    Dim cb As RadioButton = New RadioButton
                    cb.Name = "c" & i
                    cb.Text = oo(i)
                    cb.Location = New Point(10, linha)
                    cb.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 12, FontStyle.Bold)
                    cb.Size = New Size(20, 20)
                    l_resposta.Controls.Add(cb)

                    ' adiciona label
                    Dim lb As Label = New Label
                    lb.Name = "l" & i
                    lb.Text = oo(i)
                    lb.Size = New Size(260, 45)
                    'lb.BackColor = Color.Brown
                    lb.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 10, FontStyle.Bold)
                    lb.Location = New Point(35, linha)
                    l_resposta.Controls.Add(lb)


                    Dim opc As String = oo(i).ToLower
                    linha += dist '- 8 '32
                    'If opc = "outro" Or opc = "outros" Or opc = "outra" Or opc = "outras" Then
                    If opc.IndexOf("outros:") > -1 Or opc.IndexOf("outras:") > -1 Or opc.IndexOf("outro:") > -1 Or opc.IndexOf("outra:") > -1 Then
                        ' adiciona textbox a frente
                        Dim t As TextBox = New TextBox
                        t.Text = ""
                        t.Name = "outros_"
                        t.Location = New Point(10, linha)
                        t.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 12, FontStyle.Bold)
                        t.Size = New Size(200, 30)
                        l_resposta.Controls.Add(t)
                        linha += 30 '40
                        outros = True
                        Button50.Visible = True
                        Button11.Visible = True
                    End If

                Else
                    ' adiciona check
                    Dim cb As CheckBox = New CheckBox
                    cb.Name = "c" & i
                    cb.Text = oo(i)
                    cb.Size = New Size(20, 20)
                    cb.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 12, FontStyle.Bold)
                    cb.Location = New Point(10, linha)
                    l_resposta.Controls.Add(cb)

                    ' adiciona label
                    Dim lb As Label = New Label
                    lb.Name = "l" & i
                    lb.Text = oo(i)
                    lb.Size = New Size(260, 45)
                    'lb.BackColor = Color.Brown
                    lb.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 10, FontStyle.Bold)
                    lb.Location = New Point(35, linha)
                    l_resposta.Controls.Add(lb)

                    linha += dist '- 8 '32
                    Dim opc As String = oo(i).ToLower
                    'If opc = "outro" Or opc = "outros" Or opc = "outra" Or opc = "outras" Then
                    If opc.IndexOf("outros:") > -1 Or opc.IndexOf("outras:") > -1 Or opc.IndexOf("outro:") > -1 Or opc.IndexOf("outra:") > -1 Then
                        ' adiciona textbox a frente
                        Dim t As TextBox = New TextBox
                        t.Text = ""
                        t.Name = "outros_"
                        t.Location = New Point(10, linha)
                        t.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 12, FontStyle.Bold)
                        t.Size = New Size(200, 30)
                        l_resposta.Controls.Add(t)
                        linha += 30 'dist '40
                        outros = True
                        Button50.Visible = True
                        Button11.Visible = True
                    End If

                End If


            Next

        ElseIf _tipo = "Banco" Then
            ' monta telinha apresentando um list com o banco selecionado
            'ob(0) é o tipo, ob(1) a pergunta ob(2) o banco
            ' encheb_resposta com o conteudo do arquivo
            If ob(2) <> "" Then enxelist(ob(2))
            b_resposta.Visible = True
            Panel2.Visible = True
        ElseIf _tipo = "Estado e Cidade" Then
            ' monta telinha apresentando um combo com os estados e um list com as cidades
            encheestado()
            c_resposta.Visible = True
            Panel2.Visible = True
            l_p.Visible = True
            'b_resposta.Visible = False


        ElseIf _tipo = "Avaliação" Then
            ' monta telinha com options
            t_resposta.Visible = False
            l_resposta.Visible = True
            l_resposta.Controls.Clear()
            l_resposta.Location = New Point(0, 69)
            'Dim pps() As String = {"Péssimo", "Ruim", "Regular", "Bom", "Ótimo", "N/A"}
            Dim lin As Integer = 10
            Dim col As Integer = 10

            For i As Integer = 0 To 5
                Dim cb As RadioButton = New RadioButton
                cb.Name = "c" & i
                cb.Text = pps(i)
                cb.Location = New Point(col, lin)
                cb.Font = New Font(System.Drawing.FontFamily.GenericSansSerif, 7, FontStyle.Regular)
                cb.Size = New Size(140, 30)
                l_resposta.Controls.Add(cb)
                If i < 2 Then col = 10 Else col = 160
                If i = 2 Then lin = 10 Else lin = lin + 30
            Next

        End If

    End Sub
    Sub encheestado()
        pode = False
        If File.Exists(pasta & "\estados.txt") Then
            Dim obj As StreamReader = New StreamReader(pasta & "\estados.txt", System.Text.Encoding.Default)
            Dim lin As String = obj.ReadToEnd.Replace(Chr(13), "")
            obj.Close()
            Dim aa() As String = lin.Split(Chr(10))
            c_resposta.DataSource = Nothing
            c_resposta.Items.Clear()
            c_resposta.DataSource = aa
            c_resposta.SelectedIndex = -1
        End If
        pode = True
    End Sub
    Sub enxelist(ByVal arq As String)
        If File.Exists(pastaBanco & "\" & arq) Then
            Dim obj As StreamReader = New StreamReader(pastaBanco & "\" & arq, System.Text.Encoding.Default)
            Dim lin As String = obj.ReadToEnd.Replace(Chr(10), "")
            lin = lin.Replace(Chr(13), "")
            obj.Close()
            lin = lin.Replace(" , ", ",")
            lin = lin.Replace(" ,", ",")
            lin = lin.Replace(", ", ",")
            lin = lin.Replace("  , ", ",")
            lin = lin.Replace(" ,  ", ",")
            lin = lin.Replace("  ,  ", ",")

            Dim aa() As String = lin.Split(",")
            b_resposta.DataSource = Nothing
            b_resposta.Items.Clear()
            b_resposta.DataSource = aa
        End If
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click

        salvaresp()

        ' monta string de pra onde esta indo
        If _indice = questoes.Count - 1 Then
            If MsgBox("Deseja finalizar a pesquisa?", MsgBoxStyle.YesNo) <> MsgBoxResult.Yes Then Exit Sub
            ' grava e sai
            grava()
            Me.Close()
            Exit Sub
        End If

        direcao &= _indice & "|"

        ' verifica se tem salto
        Dim salto As Integer = -1
        For i As Integer = 0 To UBound(roteiro)
            If roteiro(i) Is Nothing Then Continue For
            Dim kk() As String = roteiro(i).Split("|")
            If kk(0) = _indice Then
                ' tem salto
                salto = i
                Exit For
            End If
        Next
        If salto = -1 Then
            If _indice < questoes.Count - 1 Then _indice = _indice + 1
        Else
            ' tem salto, então analisa a resposta
            Dim kk() As String = roteiro(salto).Split("|")
            Dim salt As Integer = -1
            For i As Integer = 1 To UBound(kk)
                ' verifica se tem a resposta aqui
                Dim ll() As String = kk(i).Split(";")
                If rexps(_indice) Is Nothing Then Continue For
                Dim rsp() As String = rexps(_indice).Split("|")
                For p As Integer = 0 To UBound(rsp)
                    If ll(0) = rsp(p) Then
                        ' opa tem salto
                        salt = ll(1) - 1
                        Exit For
                    End If
                Next
                If salt <> -1 Then Exit For
            Next
            ' aqui verifico se tem salt
            If salt <> -1 Then
                'opa, faço limpeza dos dados entre os saltos
                For z As Integer = _indice + 1 To salt - 1
                    resps(z) = Nothing
                    rexps(z) = -1
                Next
                _indice = salt
            Else
                If _indice < questoes.Count - 1 Then _indice = _indice + 1
            End If
        End If

        monta()
        mostraresp()
        t_resposta.SelectAll()
        t_resposta.Focus()
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        salvaresp()
        ' verifica direção

        Dim hh() As String = direcao.Split("|")
        direcao = ""

        ' ultimo  pe i hh(UBound(hh)) -1

        Dim ultdir As Integer
        If UBound(hh) - 1 >= 0 Then
            ultdir = hh(UBound(hh) - 1)
            For i As Integer = 0 To UBound(hh) - 2
                direcao &= hh(i) & "|"
            Next
        Else
            ultdir = -1
        End If



        If ultdir > -1 Then
            _indice = ultdir
        Else
            If _indice > 0 Then _indice = _indice - 1
        End If

        monta()
        mostraresp()
    End Sub
    Sub salvaresp()
        If _tipo = "Resposta Simples" Then
            resps(_indice) = t_resposta.Text
            rexps(_indice) = -1
            Exit Sub
        ElseIf _tipo = "Multipla Escolha" Then
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    If DirectCast(p, RadioButton).Checked Then
                        resps(_indice) = DirectCast(p, RadioButton).Text
                        rexps(_indice) = DirectCast(p, RadioButton).Name.Replace("c", "")
                        Dim kk As String = DirectCast(p, RadioButton).Text.ToLower
                        'If kk = "outro" Or kk = "outros" Or kk = "outra" Or kk = "outras" Then ajustaoutro(True)
                        If kk.IndexOf("outros:") > -1 Or kk.IndexOf("outras:") > -1 Or kk.IndexOf("outro:") > -1 Or kk.IndexOf("outra:") > -1 Then ajustaoutro(True)
                        Exit Sub
                    End If
                End If
            Next
        ElseIf _tipo = "Varias Escolhas" Then
            resps(_indice) = _sep '"|"
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    If DirectCast(p, CheckBox).Checked Then
                        resps(_indice) &= DirectCast(p, CheckBox).Text '& _sep ' "|"
                        rexps(_indice) &= DirectCast(p, CheckBox).Name.Replace("c", "") '& _sep '"|"
                        Dim kk As String = DirectCast(p, CheckBox).Text.ToLower
                        'If kk = "outro" Or kk = "outros" Or kk = "outra" Or kk = "outras" Then ajustaoutro(True)
                        If kk.IndexOf("outros:") > -1 Or kk.IndexOf("outras:") > -1 Or kk.IndexOf("outro:") > -1 Or kk.IndexOf("outra:") > -1 Then ajustaoutro(True)
                        resps(_indice) &= _sep
                        rexps(_indice) &= _sep
                        'Exit Sub
                    End If
                End If
            Next
        ElseIf _tipo = "Banco" Then
            resps(_indice) = b_resposta.SelectedItem
            rexps(_indice) = b_resposta.SelectedIndex
            Exit Sub
        ElseIf _tipo = "Estado e Cidade" Then
            resps(_indice) = c_resposta.Text & "/" & b_resposta.SelectedItem
            rexps(_indice) = c_resposta.SelectedIndex & "/" & b_resposta.SelectedIndex
            Exit Sub
        ElseIf _tipo = "Avaliação" Then
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    If DirectCast(p, RadioButton).Checked Then
                        resps(_indice) = DirectCast(p, RadioButton).Text
                        rexps(_indice) = DirectCast(p, RadioButton).Name.Replace("c", "")
                        Exit Sub
                    End If
                End If
            Next
        End If
    End Sub
    Function verificaoutros() As Boolean
        Dim retorno As Boolean = True
        Dim temqueter As Boolean = False

        For Each p As Control In l_resposta.Controls
            If p.Name.StartsWith("c_") Then
                If TypeOf p Is CheckBox Then
                    If DirectCast(p, CheckBox).Checked Then
                        temqueter = True
                    End If
                Else
                    If DirectCast(p, RadioButton).Checked Then
                        temqueter = True
                    End If
                End If
            End If
        Next

        For Each p As Control In l_resposta.Controls
            If p.Name.StartsWith("outros_") Then
                If temqueter Then
                    If DirectCast(p, TextBox).Text = "" Then
                        retorno = False
                    Else
                        retorno = True
                    End If
                End If
            End If
        Next

        Return retorno
    End Function

    Sub ajustaoutro(ByVal sei As Boolean)
        If sei Then
            If resps(_indice) = "" Then Exit Sub
            ' pega o valor do textbox l_resposta 
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("outros_") Then
                    resps(_indice) &= "^" & DirectCast(p, TextBox).Text
                    Exit Sub
                End If
            Next
            Exit Sub
        Else
            ' arranca outros, preenche text
            If _tipo = "Varias Escolhas" Then
                '"Multipla Escolha" Or _tipo = "Varias Escolhas" Then
                If resps(_indice).Trim = _sep Then Exit Sub
                Dim kk() As String = resps(_indice).Split("^")
                resps(_indice) = kk(0)
                If UBound(kk) > 0 Then  Else Exit Sub
                For Each p As Control In l_resposta.Controls
                    If p.Name.StartsWith("outros_") Then
                        resps(_indice) &= _sep
                        If _sep <> "" Then
                            DirectCast(p, TextBox).Text = kk(1).Replace(_sep, "")
                        Else
                            DirectCast(p, TextBox).Text = kk(1)
                        End If

                        Exit Sub
                    End If
                Next
            ElseIf _tipo = "Multipla Escolha" Then
                ' não tem sep
                Dim kk() As String = resps(_indice).Split("^")
                resps(_indice) = kk(0)
                If UBound(kk) > 0 Then  Else Exit Sub
                For Each p As Control In l_resposta.Controls
                    If p.Name.StartsWith("outros_") Then
                        DirectCast(p, TextBox).Text = kk(1)
                        Exit Sub
                    End If
                Next
            End If
        End If
    End Sub
    Sub mostraresp()
        If _indice <= UBound(resps) Then  Else Exit Sub
        If _tipo = "Resposta Simples" Then
            If resps(_indice) = Chr(13) & Chr(10) Then resps(_indice) = ""
            t_resposta.Text = resps(_indice)
            Exit Sub
        ElseIf _tipo = "Multipla Escolha" Then
            If resps(_indice) Is Nothing Then Exit Sub
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    Dim kk As String = DirectCast(p, RadioButton).Text.ToLower
                    'If kk = "outro" Or kk = "outros" Or kk = "outra" Or kk = "outras" Then ajustaoutro(False)
                    If kk.IndexOf("outros:") > -1 Or kk.IndexOf("outras:") > -1 Or kk.IndexOf("outro:") > -1 Or kk.IndexOf("outra:") > -1 Then ajustaoutro(False)
                    If DirectCast(p, RadioButton).Text = resps(_indice) Then
                        DirectCast(p, RadioButton).Checked = True
                        Exit Sub
                    End If
                End If
            Next
        ElseIf _tipo = "Varias Escolhas" Then
            If resps(_indice) Is Nothing Then Exit Sub
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    Dim kk As String = DirectCast(p, CheckBox).Text.ToLower
                    'If kk = "outro" Or kk = "outros" Or kk = "outra" Or kk = "outras" Then ajustaoutro(False)
                    If kk.IndexOf("outros:") > -1 Or kk.IndexOf("outras:") > -1 Or kk.IndexOf("outro:") > -1 Or kk.IndexOf("outra:") > -1 Then ajustaoutro(False)
                    If resps(_indice).IndexOf(_sep & DirectCast(p, CheckBox).Text & _sep) > -1 Then
                        DirectCast(p, CheckBox).Checked = True
                    End If
                End If
            Next
        ElseIf _tipo = "Banco" Then
            If resps(_indice) Is Nothing Then Exit Sub
            b_resposta.SelectedItem = resps(_indice)
            Exit Sub
        ElseIf _tipo = "Estado e Cidade" Then
            ' quebro a resposta e pego os 2
            If resps(_indice) Is Nothing Then Exit Sub
            Dim gg() As String = resps(_indice).Split("/")
            If UBound(gg) > 0 Then c_resposta.SelectedItem = gg(0)
            If UBound(gg) > 0 Then b_resposta.SelectedItem = gg(1)
        ElseIf _tipo = "Avaliação" Then
            If resps(_indice) Is Nothing Then Exit Sub
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("c") Then
                    If DirectCast(p, RadioButton).Text = resps(_indice) Then
                        DirectCast(p, RadioButton).Checked = True
                        Exit Sub
                    End If
                End If
            Next
        End If
    End Sub
    Sub pegarespostas()
        ' pega as respostas
        mycom("Select resposta, numero from respostas_" & tabmod & " where perguntaid = " & _id, 2, 0)
        'Dim ct As Integer = 0
        Do While dr(2).Read
            Dim num As Integer = dr(2).GetValue(1).ToString
            resps(num) = dr(2).GetValue(0).ToString
            rexps(num) = num
            'ct = ct + 1
        Loop
        FechaCom(2, 0)
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        Me.Close()
    End Sub

    Private Sub Button5_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button5.Click
        If MsgBox("Deseja Salvar as respostas?", MsgBoxStyle.YesNo) Then
            ' grava e sai
            grava()
        End If
    End Sub

    Private Sub t_resposta_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles t_resposta.KeyDown

    End Sub

    Private Sub t_resposta_KeyPress(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyPressEventArgs) Handles t_resposta.KeyPress
        ' avança
        If e.KeyChar = Chr(13) Then
            If t_resposta.Text <> "" Then
                e.Handled = False
                e = Nothing
                Button1_Click(Nothing, Nothing)
            End If

        End If

    End Sub

    Private Sub t_resposta_KeyUp(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles t_resposta.KeyUp

    End Sub

    Private Sub t_resposta_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_resposta.TextChanged
        Dim i As Integer = t_resposta.SelectionStart
        t_resposta.Text = t_resposta.Text.Replace(Chr(13) & Chr(10), "")
        t_resposta.SelectionStart = i
    End Sub

    Private Sub Button6_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button6.Click
        If t_resposta.SelectedText <> "" Then  Else MsgBox("Selecione um texto para incluir ao banco") : Exit Sub
        ' adiciona palavra ao banco
        insere(t_resposta.SelectedText)
        MsgBox("Palavra incluida no banco.")

    End Sub

    Private Sub Button10_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button10.Click
        Panel1.Visible = False
    End Sub

    Private Sub Button8_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button8.Click
        If DataGrid1.Item(DataGrid1.CurrentRowIndex, 1) <> "" Then
            'salva a posição do textbox
            t_resposta.Text = t_resposta.Text.Insert(pos, DataGrid1.Item(DataGrid1.CurrentRowIndex, 1).ToString)
            t_resposta.Focus()
            t_resposta.SelectionStart = pos + DataGrid1.Item(DataGrid1.CurrentRowIndex, 1).ToString.Length
        End If
        Panel1.Visible = False
    End Sub

    Private Sub Button9_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button9.Click
        ' exclui palavra do banco
        If DataGrid1.Item(DataGrid1.CurrentRowIndex, 0).ToString <> "" Then
            mycom("delete from banco where id = " & DataGrid1.Item(DataGrid1.CurrentRowIndex, 0).ToString, 0, 1)
            FechaCom(0, 1)
            enchebco()
        Else
            MsgBox("Informe a palavra a excluir.")
        End If
    End Sub
    Sub insere(ByVal oque As String)
        ' primeiro verifica se existe
        'If _con.State = ConnectionState.Closed Then _con.Open()
        '_com.CommandText = "select * from banco where palavra = ''"
        'Dim drr As SqlCeDataReader
        'drr = _com.ExecuteReader()
        'Dim achou As Boolean = False
        'Do While drr.Read
        ' achou = True
        ' Exit Sub
        ' Loop
        ' If achou Then Exit Sub
        ' drr.Close()
        If _con.State = ConnectionState.Closed Then _con.Open()
        _com.CommandText = "insert into banco (palavra) values ('" & oque & "')"
        _com.ExecuteNonQuery()
        enchebco()

    End Sub

    Private Sub Button7_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button7.Click
        ' carrega dados
        pos = t_resposta.SelectionStart
        Panel1.Visible = True
    End Sub
    Sub enchebco()
        ' enchegrid
        Dim objCnn As New SqlCeConnection("data Source =" & pasta & "\banco.sdf")
        Dim objCmd As SqlCeCommand = objCnn.CreateCommand
        objCnn.Open()
        objCmd.CommandText = "select * from banco order by palavra"
        Dim objDa As New SqlCeDataAdapter(objCmd)

        Dim objDs As New DataSet

        'objDs.Tables(oque).Columns("ID").ColumnMapping = MappingType.Hidden
        Dim oque As String = "prods"
        objDa.Fill(objDs, oque)
        DataGrid1.DataSource = objDs.Tables(oque)
        objCnn.Close()

        DataGrid1.TableStyles.Clear()

        Dim myGridTableStyle As DataGridTableStyle = New DataGridTableStyle
        myGridTableStyle.MappingName = oque

        DataGrid1.TableStyles.Add(myGridTableStyle)

        myGridTableStyle = DataGrid1.TableStyles.Item(oque)

        For i As Integer = 0 To 1
            Dim myColumnStyle As DataGridColumnStyle = myGridTableStyle.GridColumnStyles.Item(i)
            If i = 0 Then myColumnStyle.Width = 0
            If i = 1 Then myColumnStyle.Width = 140
        Next
    End Sub
    Sub grava()
        'inclui no banco

        If _id = 0 Then

            Dim cpos As String = "usuario, pergunta, resposta,  dia, hora"
            Dim vals As String = "'" & operador & "','" & questoes(0) & "','" & resps(0) & "','" & Now.ToString("yyyy-dd-MM") & "','" & Now.ToString("HH:mm:ss") & "'"
            Dim ultimo As String = "1"

            _com.CommandText = "insert into dados_" & tabmod & " (" & cpos & ") values (" & vals & ")"
            _com.ExecuteNonQuery()
            _com.CommandText = "Select @@Identity"
            ultimo = _com.ExecuteScalar().ToString

            FechaCom(2, 1)
            _id = ultimo
            xid = ultimo
            cpos = "perguntaid, numero, pergunta, resposta, dia, hora"

            For i As Integer = 0 To UBound(resps)
                If resps(i) Is Nothing Then Continue For
                vals = ultimo & ",'" & i & "','" & questoes(i).ToString & "','" & resps(i).ToString & "','" & Now.ToString("yyyy-dd-MM") & "','" & Now.ToString("HH:mm:ss") & "'"
                If _con.State = ConnectionState.Closed Then _con.Open()
                _com.CommandText = "insert into respostas_" & tabmod & " (" & cpos & ") values (" & vals & ")"
                _com.ExecuteNonQuery()
            Next
        Else
            _com.CommandText = "update dados_" & tabmod & " set pergunta = '" & questoes(0) & "', resposta = '" & resps(0) & "' where id = " & _id
            _com.ExecuteNonQuery()

            ' apaga todos no respostas

            _com.CommandText = "Delete from respostas_" & tabmod & " where perguntaid = " & _id
            _com.ExecuteNonQuery()

            Dim cpos As String = "perguntaid, numero, pergunta, resposta, dia, hora"
            Dim vals As String = ""

            For i As Integer = 0 To UBound(resps)
                If resps(i) Is Nothing Then Continue For
                vals = _id & ",'" & i & "','" & questoes(i).ToString & "','" & resps(i).ToString & "','" & Now.ToString("yyyy-dd-MM") & "','" & Now.ToString("HH:mm:ss") & "'"
                If _con.State = ConnectionState.Closed Then _con.Open()
                _com.CommandText = "insert into respostas_" & tabmod & " (" & cpos & ") values (" & vals & ")"
                _com.ExecuteNonQuery()
            Next
        End If
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        If _tipo = "Resposta Simples" Then
            t_resposta.Text = ""
            Exit Sub
        ElseIf _tipo = "Multipla Escolha" Or tipo = "Avaliação" Then
            For Each p As Control In l_resposta.Controls
                Try
                    DirectCast(p, RadioButton).Checked = False
                Catch ex As Exception

                End Try

            Next
        ElseIf _tipo = "Varias Escolhas" Then
            For Each p As Control In l_resposta.Controls
                Try
                    DirectCast(p, CheckBox).Checked = False
                Catch ex As Exception

                End Try

            Next
        ElseIf _tipo = "Banco" Then
            b_resposta.SelectedIndex = -1
        ElseIf _tipo = "Estado e Cidade" Then
            c_resposta.SelectedIndex = -1
            b_resposta.SelectedIndex = -1
        End If

    End Sub

    Private Sub Button50_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button50.Click
        If outros Then
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("outros_") Then
                    Dim k As Integer = DirectCast(p, TextBox).SelectionStart
                    dispray.Text = DirectCast(p, TextBox).Text
                    dispray.SelectionStart = k
                    tecrado.Visible = Not tecrado.Visible
                    Exit Sub
                End If
            Next
        Else
            Dim k As Integer = t_resposta.SelectionStart
            dispray.Text = t_resposta.Text
            dispray.SelectionStart = k
            tecrado.Visible = Not tecrado.Visible
        End If

    End Sub

    Private Sub Button48_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button48.Click
        tecrado.Visible = False
        t_resposta.SelectAll()
        t_resposta.Focus()
    End Sub

    Private Sub TextBox1_TextChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles dispray.TextChanged

    End Sub

    Private Sub t_q_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_q.Click, t_w.Click, t_e.Click, t_r.Click, t_t.Click, T_Y.Click, t_u.Click, t_i.Click, t_o.Click, t_p.Click, t_a.Click, t_s.Click, t_d.Click, t_f.Click, t_g.Click, t_h.Click, t_j.Click, t_k.Click, t_l.Click, t_ced.Click, t_z.Click, t_x.Click, t_c.Click, t_v.Click, t_b.Click, t_n.Click, t_m.Click, t_0.Click, t_1.Click, t_2.Click, t_3.Click, t_4.Click, t_5.Click, t_6.Click, t_7.Click, t_8.Click, t_9.Click
        ' letras e numeros
        Dim k As Integer = dispray.SelectionStart
        Dim tecla As String = DirectCast(sender, Button).Text.ToLower.Replace("t_", "").ToUpper
        If acentua <> "" Then
            tecla = acent(tecla)
            acentua = ""
        End If

        dispray.Text = dispray.Text.Insert(k, tecla)
        dispray.SelectionStart = k + 1
    End Sub
    Function acent(ByVal letra As String) As String
        Dim letr As String = letra
        If acentua = "´" Then
            If letr = "A" Then Return "Á" : Exit Function
            If letr = "E" Then Return "É" : Exit Function
            If letr = "I" Then Return "Í" : Exit Function
            If letr = "O" Then Return "Ó" : Exit Function
            If letr = "U" Then Return "Ú" : Exit Function
        End If
        If acentua = "^" Then
            If letr = "A" Then Return "Â" : Exit Function
            If letr = "E" Then Return "Ê" : Exit Function
            If letr = "O" Then Return "Ô" : Exit Function
        End If
        If acentua = "~" Then
            If letr = "A" Then Return "Ã" : Exit Function
            If letr = "O" Then Return "Õ" : Exit Function
        End If
        Return letr
    End Function
    Private Sub t_back_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_back.Click
        ' remove tecla do dispray
        Dim k As Integer = dispray.SelectionStart
        If k = 0 Then Exit Sub
        dispray.Text = dispray.Text.Remove(k - 1, 1)
        dispray.SelectionStart = k - 1
    End Sub

    Private Sub t_esp_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_esp.Click
        Dim k As Integer = dispray.SelectionStart
        dispray.Text = dispray.Text.Insert(k, " ")
        dispray.SelectionStart = k + 1
    End Sub

    Private Sub t_ponto_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_ponto.Click, t_virg.Click, t_barra.Click, t_asc.Click, t_mais.Click, t_tra.Click

        Dim k As Integer = dispray.SelectionStart
        Dim tecla As String = DirectCast(sender, Button).Text.ToLower.Replace("t_", "").ToUpper
        dispray.Text = dispray.Text.Insert(k, tecla)
        dispray.SelectionStart = k + 1
    End Sub

    Private Sub t_ag_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_ag.Click, t_circ.Click, t_tio.Click
        acentua = DirectCast(sender, Button).Text
    End Sub

    Private Sub Button49_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button49.Click
        dispray.Text = ""
    End Sub

    Private Sub t_enter_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_enter.Click
        tecrado.Visible = False
        If outros Then
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("outros_") Then
                    DirectCast(p, TextBox).Text = dispray.Text
                    DirectCast(p, TextBox).SelectionStart = DirectCast(p, TextBox).Text.Length
                    DirectCast(p, TextBox).Focus()

                    Exit Sub
                End If
            Next
        Else
            t_resposta.Text = dispray.Text
            t_resposta.SelectionStart = t_resposta.Text.Length
            t_resposta.Focus()
        End If
    End Sub

    Private Sub Button11_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button11.Click

        If outros Then
            teclado.Enabled = Not teclado.Enabled
            For Each p As Control In l_resposta.Controls
                If p.Name.StartsWith("outros_") Then
                    DirectCast(p, TextBox).SelectionStart = t_resposta.Text.Length
                    DirectCast(p, TextBox).Focus()
                    Exit Sub
                End If
            Next
        Else
            Dim k As Integer = t_resposta.SelectionStart
            teclado.Enabled = Not teclado.Enabled
            t_resposta.SelectionStart = k
            t_resposta.Focus()
        End If

    End Sub

    Private Sub c_resposta_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles c_resposta.SelectedIndexChanged
        ' selecionou, então carrega o list com os estados
        If Not pode Then Exit Sub
        If c_resposta.SelectedIndex > -1 Then  Else Exit Sub
        enxecid(c_resposta.SelectedIndex)
    End Sub
    Sub enxecid(ByVal q As Integer)
        ' pega tudo do arquivo de cidades que comecar com 1
        q = q + 1
        Dim st As String = q.ToString.PadLeft(2, "0")
        If File.Exists(pasta & "\cidades.txt") Then
            Dim obj As StreamReader = New StreamReader(pasta & "\cidades.txt", System.Text.Encoding.Default)
            Dim lin As String = obj.ReadToEnd.Replace(Chr(13), "")
            obj.Close()
            Dim aa() As String = lin.Split(Chr(10))
            b_resposta.DataSource = Nothing
            b_resposta.Items.Clear()
            For i As Integer = 0 To UBound(aa)
                If aa(i).StartsWith(st) Then b_resposta.Items.Add(aa(i).Substring(2, aa(i).Length - 3))
            Next
        End If

        b_resposta.Visible = True

    End Sub

    Private Sub Button12_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button12.Click
        '65 a 90
        Dim kk As Integer = Asc(b_letra.Text)
        If kk + 1 > 90 Then
            kk = 65
        Else
            kk = kk + 1
        End If
        b_letra.Text = Chr(kk)
    End Sub

    Private Sub Button13_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button13.Click
        Dim kk As Integer = Asc(b_letra.Text)
        If kk - 1 < 65 Then
            kk = 90
        Else
            kk = kk - 1
        End If
        b_letra.Text = Chr(kk)
    End Sub

    Private Sub b_letra_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles b_letra.Click
        b_resposta.Focus()
        OpenNETCF.Windows.Forms.SendKeys.Send(b_letra.Text)
    End Sub
End Class



Imports System.IO
Public Class questao
    Dim _indice As Integer
    Dim indvelho As Integer
    Dim _questinha As String
    Public Property questinha() As String
        Get
            questinha = _questinha
        End Get
        Set(ByVal value As String)
            _questinha = value
        End Set
    End Property
    Public Property indice() As Integer
        Get
            indice = _indice
        End Get
        Set(ByVal value As Integer)
            _indice = value
        End Set
    End Property
    Private Sub t_tipo_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles t_tipo.SelectedIndexChanged
        If t_tipo.Text = "Resposta Simples" Then Panel1.Visible = False : l1.Visible = False : t_sep.Visible = False : ListBox1.Visible = False
        If t_tipo.Text = "Multipla Escolha" Then Panel1.Visible = True : l1.Visible = False : t_sep.Visible = False : ListBox1.Visible = False
        If t_tipo.Text = "Varias Escolhas" Then Panel1.Visible = True : l1.Visible = True : t_sep.Visible = True : ListBox1.Visible = False
        If t_tipo.Text = "Estado e Cidade" Then Panel1.Visible = False : l1.Visible = False : t_sep.Visible = False : ListBox1.Visible = False
        If t_tipo.Text = "Banco" Then Panel1.Visible = False : l1.Visible = False : t_sep.Visible = False : ListBox1.Visible = True
        If t_tipo.Text = "Avaliação" Then Panel1.Visible = False : l1.Visible = False : t_sep.Visible = False : ListBox1.Visible = False
    End Sub

    Private Sub questao_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        indvelho = -1
        Panel1.Visible = False
        l_numero.Text = _indice
        carregaBancos()
        If _questinha <> "" Then
            ' coloca valores
            Dim ob() As String = questoes(_indice).ToString.Split("|")
            t_tipo.Text = ob(0)
            t_pergunta.Text = ob(1)
            If ob(0) <> "Resposta Simples" And ob(0) <> "Banco" Then
                'quebra as respostas
                Dim jj() As String = ob(2).Split("¨")
                t_resp.Text = ""
                For i As Integer = 0 To UBound(jj)
                    t_resp.Text &= jj(i) & vbCrLf
                Next
                Try
                    If t_tipo.Text = "Varias Escolhas" Then t_sep.Text = ob(3)
                Catch ex As Exception

                End Try
            ElseIf ob(0) = "Banco" Then
                ' selecione o valor no list, igual ao do valor do ob2
                For i As Integer = 0 To ListBox1.Items.Count - 1
                    If ListBox1.Items.Item(i) = ob(2) Then
                        ListBox1.SelectedIndex = i
                        Exit For
                    End If
                Next
            End If

        End If
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        t_pergunta.Text = t_pergunta.Text.Replace(Chr(13), "")
        t_pergunta.Text = t_pergunta.Text.Replace(Chr(10), "")

        
        If t_pergunta.Text <> "" Then  Else MsgBox("Informe a pergunta.") : Exit Sub

        If t_tipo.Text <> "" Then  Else MsgBox("Informe o tipo da pergunta.") : Exit Sub
        If t_tipo.Text = "Multipla Escolha" Or t_tipo.Text = "Varias Escolhas" Then
            If t_resp.Text <> "" Then  Else MsgBox("Informe a resposta.") : Exit Sub
            If t_tipo.Text = "Varias Escolhas" Then
                If t_sep.Text <> "" Then  Else MsgBox("Informe o separador das respostas.") : Exit Sub
            End If
        End If

        Dim resposta As String = ""
        If t_tipo.Text = "Multipla Escolha" Or t_tipo.Text = "Varias Escolhas" Then
            resposta = ""
            Dim kk As String = t_resp.Text.Replace(Chr(10), "")
            Dim oo() As String = kk.Split(Chr(13))
            For i As Integer = 0 To UBound(oo)
                Dim ss As String = ""
                If i <> UBound(oo) Then ss = "¨" Else ss = ""
                If oo(i) <> "" Then resposta &= oo(i) & ss
            Next
            'poe o separador
            If t_tipo.Text = "Varias Escolhas" Then
                resposta &= "|" & t_sep.Text
            End If
        End If

        'se for banco
        If t_tipo.Text = "Banco" Then
            If Not ListBox1.SelectedItem Is Nothing Then
                resposta = ListBox1.SelectedItem.ToString
            Else
                MsgBox("Informe o banco")
                Exit Sub
            End If

        End If

        indvelho = 1
        If _indice > questoes.Count - 1 Then
            questoes.Add(t_tipo.Text & "|" & t_pergunta.Text & "|" & resposta)
        Else
            questoes(_indice) = t_tipo.Text & "|" & t_pergunta.Text & "|" & resposta
        End If

        _indice = 1
        Me.Close()

    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        _indice = indvelho
        Me.Close()
    End Sub

    Private Sub t_pergunta_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles t_pergunta.KeyDown
        If e.KeyCode = Keys.Enter Then
            If t_tipo.Text = "Multipla Escolha" Or t_tipo.Text = "Varias Escolhas" Then
                t_resp.Focus()
                Exit Sub
            Else
                Button1.Focus()
            End If
        End If
    End Sub

    Private Sub carregaBancos()
        ListBox1.Items.Clear()
        If Not Directory.Exists(pastaBanco) Then
            Directory.CreateDirectory(pastaBanco)
        End If
        Dim di As New DirectoryInfo(pastaBanco)
        Dim aryFi As FileInfo() = di.GetFiles("*.txt")
        Dim fi As FileInfo
        ListBox1.Items.Clear()
        For Each fi In aryFi
            ListBox1.Items.Add(fi.Name)
        Next
    End Sub
End Class



<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class param
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.Button1 = New System.Windows.Forms.Button
        Me.Label2 = New System.Windows.Forms.Label
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.ListBox1 = New System.Windows.Forms.ListBox
        Me.Button6 = New System.Windows.Forms.Button
        Me.Button8 = New System.Windows.Forms.Button
        Me.Button7 = New System.Windows.Forms.Button
        Me.t_pesq = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.Button9 = New System.Windows.Forms.Button
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.BackColor = System.Drawing.Color.Green
        Me.Button1.Font = New System.Drawing.Font("Arial", 20.0!, System.Drawing.FontStyle.Bold)
        Me.Button1.ForeColor = System.Drawing.Color.White
        Me.Button1.Location = New System.Drawing.Point(4, 228)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(50, 30)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "+"
        '
        'Label2
        '
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(3, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(73, 20)
        Me.Label2.Text = "Questões"
        '
        'Button2
        '
        Me.Button2.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button2.Font = New System.Drawing.Font("Arial", 20.0!, System.Drawing.FontStyle.Bold)
        Me.Button2.ForeColor = System.Drawing.Color.White
        Me.Button2.Location = New System.Drawing.Point(60, 228)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(50, 30)
        Me.Button2.TabIndex = 7
        Me.Button2.Text = "-"
        '
        'Button3
        '
        Me.Button3.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Button3.Font = New System.Drawing.Font("Wingdings", 20.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Button3.ForeColor = System.Drawing.Color.White
        Me.Button3.Location = New System.Drawing.Point(248, 228)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(50, 30)
        Me.Button3.TabIndex = 8
        Me.Button3.Text = "û"
        '
        'Button4
        '
        Me.Button4.BackColor = System.Drawing.Color.Yellow
        Me.Button4.Font = New System.Drawing.Font("Wingdings", 22.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Button4.Location = New System.Drawing.Point(116, 228)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(50, 30)
        Me.Button4.TabIndex = 9
        Me.Button4.Text = "$"
        '
        'Button5
        '
        Me.Button5.BackColor = System.Drawing.Color.Fuchsia
        Me.Button5.Font = New System.Drawing.Font("Arial", 12.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Button5.ForeColor = System.Drawing.Color.White
        Me.Button5.Location = New System.Drawing.Point(172, 228)
        Me.Button5.Name = "Button5"
        Me.Button5.Size = New System.Drawing.Size(70, 30)
        Me.Button5.TabIndex = 10
        Me.Button5.Text = "Salvar"
        '
        'ListBox1
        '
        Me.ListBox1.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.ListBox1.Location = New System.Drawing.Point(4, 64)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.Size = New System.Drawing.Size(294, 162)
        Me.ListBox1.TabIndex = 11
        '
        'Button6
        '
        Me.Button6.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button6.Font = New System.Drawing.Font("Wingdings", 16.0!, System.Drawing.FontStyle.Bold)
        Me.Button6.ForeColor = System.Drawing.Color.White
        Me.Button6.Location = New System.Drawing.Point(197, 2)
        Me.Button6.Name = "Button6"
        Me.Button6.Size = New System.Drawing.Size(50, 30)
        Me.Button6.TabIndex = 12
        Me.Button6.Text = "é"
        '
        'Button8
        '
        Me.Button8.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button8.Font = New System.Drawing.Font("Wingdings", 16.0!, System.Drawing.FontStyle.Bold)
        Me.Button8.ForeColor = System.Drawing.Color.White
        Me.Button8.Location = New System.Drawing.Point(248, 2)
        Me.Button8.Name = "Button8"
        Me.Button8.Size = New System.Drawing.Size(50, 30)
        Me.Button8.TabIndex = 14
        Me.Button8.Text = "ê"
        '
        'Button7
        '
        Me.Button7.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button7.Font = New System.Drawing.Font("Arial", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button7.ForeColor = System.Drawing.Color.White
        Me.Button7.Location = New System.Drawing.Point(124, 2)
        Me.Button7.Name = "Button7"
        Me.Button7.Size = New System.Drawing.Size(70, 30)
        Me.Button7.TabIndex = 16
        Me.Button7.Text = "Roteiros"
        '
        't_pesq
        '
        Me.t_pesq.Location = New System.Drawing.Point(93, 37)
        Me.t_pesq.Name = "t_pesq"
        Me.t_pesq.Size = New System.Drawing.Size(205, 23)
        Me.t_pesq.TabIndex = 18
        '
        'Label1
        '
        Me.Label1.ForeColor = System.Drawing.Color.White
        Me.Label1.Location = New System.Drawing.Point(4, 37)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(73, 20)
        Me.Label1.Text = "Pesquisa:"
        '
        'Button9
        '
        Me.Button9.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button9.Font = New System.Drawing.Font("Arial", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button9.ForeColor = System.Drawing.Color.White
        Me.Button9.Location = New System.Drawing.Point(73, 2)
        Me.Button9.Name = "Button9"
        Me.Button9.Size = New System.Drawing.Size(51, 30)
        Me.Button9.TabIndex = 20
        Me.Button9.Text = "AVLs"
        '
        'param
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(96.0!, 96.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
        Me.AutoScroll = True
        Me.BackColor = System.Drawing.Color.Black
        Me.ClientSize = New System.Drawing.Size(436, 380)
        Me.ControlBox = False
        Me.Controls.Add(Me.Button9)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.t_pesq)
        Me.Controls.Add(Me.Button7)
        Me.Controls.Add(Me.Button8)
        Me.Controls.Add(Me.Button6)
        Me.Controls.Add(Me.ListBox1)
        Me.Controls.Add(Me.Button5)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Button1)
        Me.Name = "param"
        Me.Text = "Parametrização"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
    Friend WithEvents Button6 As System.Windows.Forms.Button
    Friend WithEvents Button8 As System.Windows.Forms.Button
    Friend WithEvents Button7 As System.Windows.Forms.Button
    Friend WithEvents t_pesq As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Button9 As System.Windows.Forms.Button
End Class


<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class questao
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.t_tipo = New System.Windows.Forms.ComboBox
        Me.t_pergunta = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.l_numero = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.Label3 = New System.Windows.Forms.Label
        Me.t_resp = New System.Windows.Forms.TextBox
        Me.Button3 = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.l1 = New System.Windows.Forms.Label
        Me.t_sep = New System.Windows.Forms.TextBox
        Me.ListBox1 = New System.Windows.Forms.ListBox
        Me.Panel1.SuspendLayout()
        Me.SuspendLayout()
        '
        't_tipo
        '
        Me.t_tipo.Items.Add("Resposta Simples")
        Me.t_tipo.Items.Add("Multipla Escolha")
        Me.t_tipo.Items.Add("Varias Escolhas")
        Me.t_tipo.Items.Add("Estado e Cidade")
        Me.t_tipo.Items.Add("Banco")
        Me.t_tipo.Items.Add("Avaliação")
        Me.t_tipo.Location = New System.Drawing.Point(129, 3)
        Me.t_tipo.Name = "t_tipo"
        Me.t_tipo.Size = New System.Drawing.Size(143, 23)
        Me.t_tipo.TabIndex = 6
        '
        't_pergunta
        '
        Me.t_pergunta.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_pergunta.Location = New System.Drawing.Point(3, 32)
        Me.t_pergunta.Multiline = True
        Me.t_pergunta.Name = "t_pergunta"
        Me.t_pergunta.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.t_pergunta.Size = New System.Drawing.Size(312, 59)
        Me.t_pergunta.TabIndex = 5
        '
        'Label1
        '
        Me.Label1.ForeColor = System.Drawing.Color.White
        Me.Label1.Location = New System.Drawing.Point(92, 5)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(42, 20)
        Me.Label1.Text = "Tipo"
        '
        'l_numero
        '
        Me.l_numero.Font = New System.Drawing.Font("Tahoma", 14.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.l_numero.ForeColor = System.Drawing.Color.White
        Me.l_numero.Location = New System.Drawing.Point(275, 4)
        Me.l_numero.Name = "l_numero"
        Me.l_numero.Size = New System.Drawing.Size(40, 20)
        Me.l_numero.Text = "1"
        '
        'Label2
        '
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(3, 4)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(71, 20)
        Me.Label2.Text = "Pergunta:"
        '
        'Label3
        '
        Me.Label3.ForeColor = System.Drawing.Color.White
        Me.Label3.Location = New System.Drawing.Point(4, 1)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(67, 20)
        Me.Label3.Text = "Opções"
        '
        't_resp
        '
        Me.t_resp.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_resp.Location = New System.Drawing.Point(4, 29)
        Me.t_resp.Multiline = True
        Me.t_resp.Name = "t_resp"
        Me.t_resp.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.t_resp.Size = New System.Drawing.Size(305, 99)
        Me.t_resp.TabIndex = 14
        '
        'Button3
        '
        Me.Button3.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button3.Font = New System.Drawing.Font("Wingdings", 20.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Button3.ForeColor = System.Drawing.Color.White
        Me.Button3.Location = New System.Drawing.Point(262, 236)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(50, 30)
        Me.Button3.TabIndex = 15
        Me.Button3.Text = "û"
        '
        'Button1
        '
        Me.Button1.BackColor = System.Drawing.Color.Green
        Me.Button1.Font = New System.Drawing.Font("Wingdings", 20.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Button1.ForeColor = System.Drawing.Color.White
        Me.Button1.Location = New System.Drawing.Point(3, 236)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(50, 30)
        Me.Button1.TabIndex = 16
        Me.Button1.Text = "ü"
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.Panel1.Controls.Add(Me.ListBox1)
        Me.Panel1.Controls.Add(Me.l1)
        Me.Panel1.Controls.Add(Me.t_sep)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.t_resp)
        Me.Panel1.Location = New System.Drawing.Point(3, 94)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(315, 136)
        '
        'l1
        '
        Me.l1.ForeColor = System.Drawing.Color.White
        Me.l1.Location = New System.Drawing.Point(195, 5)
        Me.l1.Name = "l1"
        Me.l1.Size = New System.Drawing.Size(67, 20)
        Me.l1.Text = "Separador"
        '
        't_sep
        '
        Me.t_sep.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.t_sep.Location = New System.Drawing.Point(265, 3)
        Me.t_sep.MaxLength = 5
        Me.t_sep.Name = "t_sep"
        Me.t_sep.Size = New System.Drawing.Size(44, 23)
        Me.t_sep.TabIndex = 20
        Me.t_sep.Text = ","
        '
        'ListBox1
        '
        Me.ListBox1.Location = New System.Drawing.Point(-3, 1)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.Size = New System.Drawing.Size(321, 130)
        Me.ListBox1.TabIndex = 29
        Me.ListBox1.Visible = False
        '
        'questao
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(96.0!, 96.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
        Me.AutoScroll = True
        Me.BackColor = System.Drawing.Color.Black
        Me.ClientSize = New System.Drawing.Size(324, 295)
        Me.ControlBox = False
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.l_numero)
        Me.Controls.Add(Me.t_tipo)
        Me.Controls.Add(Me.t_pergunta)
        Me.Controls.Add(Me.Label1)
        Me.Name = "questao"
        Me.Text = "Questões"
        Me.Panel1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents t_tipo As System.Windows.Forms.ComboBox
    Friend WithEvents t_pergunta As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents l_numero As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents t_resp As System.Windows.Forms.TextBox
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents l1 As System.Windows.Forms.Label
    Friend WithEvents t_sep As System.Windows.Forms.TextBox
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
End Class

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class roteiros
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.ListBox1 = New System.Windows.Forms.ListBox
        Me.Label2 = New System.Windows.Forms.Label
        Me.ListBox2 = New System.Windows.Forms.ListBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.ComboBox1 = New System.Windows.Forms.ComboBox
        Me.Button3 = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.Button6 = New System.Windows.Forms.Button
        Me.Button7 = New System.Windows.Forms.Button
        Me.ListBox3 = New System.Windows.Forms.ListBox
        Me.Button1 = New System.Windows.Forms.Button
        Me.SuspendLayout()
        '
        'ListBox1
        '
        Me.ListBox1.Location = New System.Drawing.Point(0, 23)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.Size = New System.Drawing.Size(315, 82)
        Me.ListBox1.TabIndex = 12
        '
        'Label2
        '
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(0, 0)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(140, 20)
        Me.Label2.Text = "Selecione a questão"
        '
        'ListBox2
        '
        Me.ListBox2.Location = New System.Drawing.Point(2, 106)
        Me.ListBox2.Name = "ListBox2"
        Me.ListBox2.Size = New System.Drawing.Size(138, 82)
        Me.ListBox2.TabIndex = 15
        '
        'Label1
        '
        Me.Label1.ForeColor = System.Drawing.Color.White
        Me.Label1.Location = New System.Drawing.Point(146, 108)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(116, 20)
        Me.Label1.Text = "Vá Para"
        '
        'ComboBox1
        '
        Me.ComboBox1.Location = New System.Drawing.Point(146, 131)
        Me.ComboBox1.Name = "ComboBox1"
        Me.ComboBox1.Size = New System.Drawing.Size(169, 23)
        Me.ComboBox1.TabIndex = 18
        '
        'Button3
        '
        Me.Button3.BackColor = System.Drawing.Color.Green
        Me.Button3.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button3.ForeColor = System.Drawing.Color.White
        Me.Button3.Location = New System.Drawing.Point(146, 160)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(50, 26)
        Me.Button3.TabIndex = 20
        Me.Button3.Text = "ok"
        '
        'Button4
        '
        Me.Button4.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button4.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button4.ForeColor = System.Drawing.Color.White
        Me.Button4.Location = New System.Drawing.Point(265, 160)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(50, 26)
        Me.Button4.TabIndex = 21
        Me.Button4.Text = "[ ]"
        '
        'Button5
        '
        Me.Button5.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button5.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button5.ForeColor = System.Drawing.Color.White
        Me.Button5.Location = New System.Drawing.Point(236, 201)
        Me.Button5.Name = "Button5"
        Me.Button5.Size = New System.Drawing.Size(79, 39)
        Me.Button5.TabIndex = 22
        Me.Button5.Text = "Sair"
        '
        'Button6
        '
        Me.Button6.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button6.Location = New System.Drawing.Point(0, 223)
        Me.Button6.Name = "Button6"
        Me.Button6.Size = New System.Drawing.Size(79, 39)
        Me.Button6.TabIndex = 23
        Me.Button6.Text = "Ver Mapa"
        '
        'Button7
        '
        Me.Button7.BackColor = System.Drawing.Color.Green
        Me.Button7.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button7.ForeColor = System.Drawing.Color.White
        Me.Button7.Location = New System.Drawing.Point(0, 224)
        Me.Button7.Name = "Button7"
        Me.Button7.Size = New System.Drawing.Size(79, 39)
        Me.Button7.TabIndex = 25
        Me.Button7.Text = "Salvar"
        '
        'ListBox3
        '
        Me.ListBox3.Location = New System.Drawing.Point(88, 197)
        Me.ListBox3.Name = "ListBox3"
        Me.ListBox3.Size = New System.Drawing.Size(142, 66)
        Me.ListBox3.TabIndex = 26
        '
        'Button1
        '
        Me.Button1.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.Button1.Font = New System.Drawing.Font("Arial", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button1.ForeColor = System.Drawing.Color.White
        Me.Button1.Location = New System.Drawing.Point(202, 160)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(50, 26)
        Me.Button1.TabIndex = 34
        Me.Button1.Text = "-"
        '
        'roteiros
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(96.0!, 96.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
        Me.AutoScroll = True
        Me.BackColor = System.Drawing.Color.Black
        Me.ClientSize = New System.Drawing.Size(318, 295)
        Me.ControlBox = False
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.ListBox3)
        Me.Controls.Add(Me.Button7)
        Me.Controls.Add(Me.Button6)
        Me.Controls.Add(Me.Button5)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.ComboBox1)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.ListBox2)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.ListBox1)
        Me.Name = "roteiros"
        Me.Text = "Roteiros"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents ListBox2 As System.Windows.Forms.ListBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents Button6 As System.Windows.Forms.Button
    Friend WithEvents Button7 As System.Windows.Forms.Button
    Friend WithEvents ListBox3 As System.Windows.Forms.ListBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
End Class


<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class aplic
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.l_pergunta = New System.Windows.Forms.Label
        Me.t_resposta = New System.Windows.Forms.TextBox
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button3 = New System.Windows.Forms.Button
        Me.Label2 = New System.Windows.Forms.Label
        Me.l_tipo = New System.Windows.Forms.Label
        Me.l_resposta = New System.Windows.Forms.Panel
        Me.Button4 = New System.Windows.Forms.Button
        Me.Button5 = New System.Windows.Forms.Button
        Me.Button6 = New System.Windows.Forms.Button
        Me.Button7 = New System.Windows.Forms.Button
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.DataGrid1 = New System.Windows.Forms.DataGrid
        Me.Button10 = New System.Windows.Forms.Button
        Me.Button9 = New System.Windows.Forms.Button
        Me.Button8 = New System.Windows.Forms.Button
        Me.Button1 = New System.Windows.Forms.Button
        Me.Button50 = New System.Windows.Forms.Button
        Me.t_t = New System.Windows.Forms.Button
        Me.t_r = New System.Windows.Forms.Button
        Me.T_Y = New System.Windows.Forms.Button
        Me.t_e = New System.Windows.Forms.Button
        Me.t_u = New System.Windows.Forms.Button
        Me.t_w = New System.Windows.Forms.Button
        Me.t_i = New System.Windows.Forms.Button
        Me.t_q = New System.Windows.Forms.Button
        Me.t_o = New System.Windows.Forms.Button
        Me.t_p = New System.Windows.Forms.Button
        Me.t_g = New System.Windows.Forms.Button
        Me.t_f = New System.Windows.Forms.Button
        Me.t_h = New System.Windows.Forms.Button
        Me.t_d = New System.Windows.Forms.Button
        Me.t_j = New System.Windows.Forms.Button
        Me.t_s = New System.Windows.Forms.Button
        Me.t_k = New System.Windows.Forms.Button
        Me.t_a = New System.Windows.Forms.Button
        Me.t_l = New System.Windows.Forms.Button
        Me.t_ced = New System.Windows.Forms.Button
        Me.t_b = New System.Windows.Forms.Button
        Me.t_v = New System.Windows.Forms.Button
        Me.t_n = New System.Windows.Forms.Button
        Me.t_c = New System.Windows.Forms.Button
        Me.t_m = New System.Windows.Forms.Button
        Me.t_x = New System.Windows.Forms.Button
        Me.t_ponto = New System.Windows.Forms.Button
        Me.t_z = New System.Windows.Forms.Button
        Me.t_virg = New System.Windows.Forms.Button
        Me.t_barra = New System.Windows.Forms.Button
        Me.t_8 = New System.Windows.Forms.Button
        Me.t_9 = New System.Windows.Forms.Button
        Me.t_7 = New System.Windows.Forms.Button
        Me.t_esp = New System.Windows.Forms.Button
        Me.t_5 = New System.Windows.Forms.Button
        Me.t_6 = New System.Windows.Forms.Button
        Me.t_back = New System.Windows.Forms.Button
        Me.t_4 = New System.Windows.Forms.Button
        Me.t_2 = New System.Windows.Forms.Button
        Me.t_ag = New System.Windows.Forms.Button
        Me.t_3 = New System.Windows.Forms.Button
        Me.t_1 = New System.Windows.Forms.Button
        Me.t_tio = New System.Windows.Forms.Button
        Me.t_0 = New System.Windows.Forms.Button
        Me.t_circ = New System.Windows.Forms.Button
        Me.t_tra = New System.Windows.Forms.Button
        Me.t_enter = New System.Windows.Forms.Button
        Me.dispray = New System.Windows.Forms.TextBox
        Me.Button48 = New System.Windows.Forms.Button
        Me.Button49 = New System.Windows.Forms.Button
        Me.tecrado = New System.Windows.Forms.Panel
        Me.t_asc = New System.Windows.Forms.Button
        Me.t_mais = New System.Windows.Forms.Button
        Me.Button11 = New System.Windows.Forms.Button
        Me.b_resposta = New System.Windows.Forms.ListBox
        Me.c_resposta = New System.Windows.Forms.ComboBox
        Me.Panel2 = New System.Windows.Forms.Panel
        Me.b_letra = New System.Windows.Forms.Button
        Me.Button13 = New System.Windows.Forms.Button
        Me.Button12 = New System.Windows.Forms.Button
        Me.l_p = New System.Windows.Forms.Label
        Me.Panel1.SuspendLayout()
        Me.tecrado.SuspendLayout()
        Me.Panel2.SuspendLayout()
        Me.SuspendLayout()
        '
        'l_pergunta
        '
        Me.l_pergunta.BackColor = System.Drawing.Color.Gray
        Me.l_pergunta.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.l_pergunta.ForeColor = System.Drawing.Color.White
        Me.l_pergunta.Location = New System.Drawing.Point(2, 21)
        Me.l_pergunta.Name = "l_pergunta"
        Me.l_pergunta.Size = New System.Drawing.Size(312, 47)
        Me.l_pergunta.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        't_resposta
        '
        Me.t_resposta.Font = New System.Drawing.Font("Tahoma", 16.0!, System.Drawing.FontStyle.Bold)
        Me.t_resposta.Location = New System.Drawing.Point(0, 101)
        Me.t_resposta.Multiline = True
        Me.t_resposta.Name = "t_resposta"
        Me.t_resposta.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.t_resposta.Size = New System.Drawing.Size(314, 116)
        Me.t_resposta.TabIndex = 1
        '
        'Button2
        '
        Me.Button2.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Button2.Font = New System.Drawing.Font("Wingdings", 20.0!, System.Drawing.FontStyle.Bold)
        Me.Button2.ForeColor = System.Drawing.Color.White
        Me.Button2.Location = New System.Drawing.Point(0, 217)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(56, 51)
        Me.Button2.TabIndex = 4
        Me.Button2.Text = "ç"
        '
        'Button3
        '
        Me.Button3.BackColor = System.Drawing.Color.Yellow
        Me.Button3.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button3.ForeColor = System.Drawing.Color.Black
        Me.Button3.Location = New System.Drawing.Point(128, 217)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(62, 25)
        Me.Button3.TabIndex = 5
        Me.Button3.Text = "Limpar"
        '
        'Label2
        '
        Me.Label2.BackColor = System.Drawing.Color.Black
        Me.Label2.Font = New System.Drawing.Font("Tahoma", 14.0!, CType((System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic), System.Drawing.FontStyle))
        Me.Label2.ForeColor = System.Drawing.Color.White
        Me.Label2.Location = New System.Drawing.Point(57, 217)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(62, 51)
        Me.Label2.Text = "100"
        Me.Label2.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'l_tipo
        '
        Me.l_tipo.ForeColor = System.Drawing.Color.White
        Me.l_tipo.Location = New System.Drawing.Point(30, 0)
        Me.l_tipo.Name = "l_tipo"
        Me.l_tipo.Size = New System.Drawing.Size(238, 20)
        Me.l_tipo.TextAlign = System.Drawing.ContentAlignment.TopCenter
        '
        'l_resposta
        '
        Me.l_resposta.AutoScroll = True
        Me.l_resposta.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(192, Byte), Integer), CType(CType(255, Byte), Integer))
        Me.l_resposta.Location = New System.Drawing.Point(340, 69)
        Me.l_resposta.Name = "l_resposta"
        Me.l_resposta.Size = New System.Drawing.Size(315, 146)
        '
        'Button4
        '
        Me.Button4.BackColor = System.Drawing.Color.Red
        Me.Button4.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button4.ForeColor = System.Drawing.Color.White
        Me.Button4.Location = New System.Drawing.Point(128, 243)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(62, 25)
        Me.Button4.TabIndex = 9
        Me.Button4.Text = "Sair"
        '
        'Button5
        '
        Me.Button5.BackColor = System.Drawing.Color.Green
        Me.Button5.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button5.ForeColor = System.Drawing.Color.White
        Me.Button5.Location = New System.Drawing.Point(196, 217)
        Me.Button5.Name = "Button5"
        Me.Button5.Size = New System.Drawing.Size(56, 51)
        Me.Button5.TabIndex = 10
        Me.Button5.Text = "Salvar"
        '
        'Button6
        '
        Me.Button6.BackColor = System.Drawing.Color.Navy
        Me.Button6.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button6.ForeColor = System.Drawing.Color.White
        Me.Button6.Location = New System.Drawing.Point(196, 71)
        Me.Button6.Name = "Button6"
        Me.Button6.Size = New System.Drawing.Size(56, 26)
        Me.Button6.TabIndex = 15
        Me.Button6.Text = "+bco"
        '
        'Button7
        '
        Me.Button7.BackColor = System.Drawing.Color.Navy
        Me.Button7.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button7.ForeColor = System.Drawing.Color.White
        Me.Button7.Location = New System.Drawing.Point(258, 71)
        Me.Button7.Name = "Button7"
        Me.Button7.Size = New System.Drawing.Size(56, 26)
        Me.Button7.TabIndex = 16
        Me.Button7.Text = "BCO"
        '
        'Panel1
        '
        Me.Panel1.AutoScroll = True
        Me.Panel1.BackColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(255, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Panel1.Controls.Add(Me.DataGrid1)
        Me.Panel1.Controls.Add(Me.Button10)
        Me.Panel1.Controls.Add(Me.Button9)
        Me.Panel1.Controls.Add(Me.Button8)
        Me.Panel1.Location = New System.Drawing.Point(512, 255)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(169, 172)
        '
        'DataGrid1
        '
        Me.DataGrid1.BackgroundColor = System.Drawing.Color.FromArgb(CType(CType(128, Byte), Integer), CType(CType(128, Byte), Integer), CType(CType(128, Byte), Integer))
        Me.DataGrid1.Location = New System.Drawing.Point(3, 2)
        Me.DataGrid1.Name = "DataGrid1"
        Me.DataGrid1.Size = New System.Drawing.Size(160, 131)
        Me.DataGrid1.TabIndex = 19
        '
        'Button10
        '
        Me.Button10.Location = New System.Drawing.Point(119, 139)
        Me.Button10.Name = "Button10"
        Me.Button10.Size = New System.Drawing.Size(44, 26)
        Me.Button10.TabIndex = 18
        Me.Button10.Text = "X"
        '
        'Button9
        '
        Me.Button9.Location = New System.Drawing.Point(61, 139)
        Me.Button9.Name = "Button9"
        Me.Button9.Size = New System.Drawing.Size(44, 26)
        Me.Button9.TabIndex = 17
        Me.Button9.Text = "-"
        '
        'Button8
        '
        Me.Button8.Location = New System.Drawing.Point(4, 139)
        Me.Button8.Name = "Button8"
        Me.Button8.Size = New System.Drawing.Size(44, 26)
        Me.Button8.TabIndex = 16
        Me.Button8.Text = "OK"
        '
        'Button1
        '

        Me.Button1.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Button1.Font = New System.Drawing.Font("Wingdings", 18.0!, System.Drawing.FontStyle.Bold)
        Me.Button1.ForeColor = System.Drawing.Color.White
        Me.Button1.Location = New System.Drawing.Point(258, 217)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(56, 51)
        Me.Button1.TabIndex = 3
        Me.Button1.Text = "è"
        '
        'Button50
        '
        Me.Button50.BackColor = System.Drawing.Color.Navy
        Me.Button50.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button50.ForeColor = System.Drawing.Color.White
        Me.Button50.Location = New System.Drawing.Point(285, 0)
        Me.Button50.Name = "Button50"
        Me.Button50.Size = New System.Drawing.Size(30, 20)
        Me.Button50.TabIndex = 22
        Me.Button50.Text = "T"
        '
        't_t
        '
        Me.t_t.BackColor = System.Drawing.Color.Navy
        Me.t_t.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_t.ForeColor = System.Drawing.Color.White
        Me.t_t.Location = New System.Drawing.Point(131, 60)
        Me.t_t.Name = "t_t"
        Me.t_t.Size = New System.Drawing.Size(30, 40)
        Me.t_t.TabIndex = 26
        Me.t_t.Text = "T"
        '
        't_r
        '
        Me.t_r.BackColor = System.Drawing.Color.Navy
        Me.t_r.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_r.ForeColor = System.Drawing.Color.White
        Me.t_r.Location = New System.Drawing.Point(101, 60)
        Me.t_r.Name = "t_r"
        Me.t_r.Size = New System.Drawing.Size(30, 40)
        Me.t_r.TabIndex = 25
        Me.t_r.Text = "R"
        '
        'T_Y
        '
        Me.T_Y.BackColor = System.Drawing.Color.Navy
        Me.T_Y.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.T_Y.ForeColor = System.Drawing.Color.White
        Me.T_Y.Location = New System.Drawing.Point(161, 60)
        Me.T_Y.Name = "T_Y"
        Me.T_Y.Size = New System.Drawing.Size(30, 40)
        Me.T_Y.TabIndex = 27
        Me.T_Y.Text = "Y"
        '
        't_e
        '
        Me.t_e.BackColor = System.Drawing.Color.Navy
        Me.t_e.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_e.ForeColor = System.Drawing.Color.White
        Me.t_e.Location = New System.Drawing.Point(71, 60)
        Me.t_e.Name = "t_e"
        Me.t_e.Size = New System.Drawing.Size(30, 40)
        Me.t_e.TabIndex = 24
        Me.t_e.Text = "E"
        '
        't_u
        '
        Me.t_u.BackColor = System.Drawing.Color.Navy
        Me.t_u.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_u.ForeColor = System.Drawing.Color.White
        Me.t_u.Location = New System.Drawing.Point(191, 60)
        Me.t_u.Name = "t_u"
        Me.t_u.Size = New System.Drawing.Size(30, 40)
        Me.t_u.TabIndex = 28
        Me.t_u.Text = "U"
        '
        't_w
        '
        Me.t_w.BackColor = System.Drawing.Color.Navy
        Me.t_w.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_w.ForeColor = System.Drawing.Color.White
        Me.t_w.Location = New System.Drawing.Point(41, 60)
        Me.t_w.Name = "t_w"
        Me.t_w.Size = New System.Drawing.Size(30, 40)
        Me.t_w.TabIndex = 23
        Me.t_w.Text = "W"
        '
        't_i
        '
        Me.t_i.BackColor = System.Drawing.Color.Navy
        Me.t_i.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_i.ForeColor = System.Drawing.Color.White
        Me.t_i.Location = New System.Drawing.Point(221, 60)
        Me.t_i.Name = "t_i"
        Me.t_i.Size = New System.Drawing.Size(30, 40)
        Me.t_i.TabIndex = 29
        Me.t_i.Text = "I"
        '
        't_q
        '
        Me.t_q.BackColor = System.Drawing.Color.Navy
        Me.t_q.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_q.ForeColor = System.Drawing.Color.White
        Me.t_q.Location = New System.Drawing.Point(11, 60)
        Me.t_q.Name = "t_q"
        Me.t_q.Size = New System.Drawing.Size(30, 40)
        Me.t_q.TabIndex = 22
        Me.t_q.Text = "Q"
        '
        't_o
        '
        Me.t_o.BackColor = System.Drawing.Color.Navy
        Me.t_o.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_o.ForeColor = System.Drawing.Color.White
        Me.t_o.Location = New System.Drawing.Point(251, 60)
        Me.t_o.Name = "t_o"
        Me.t_o.Size = New System.Drawing.Size(30, 40)
        Me.t_o.TabIndex = 30
        Me.t_o.Text = "O"
        '
        't_p
        '
        Me.t_p.BackColor = System.Drawing.Color.Navy
        Me.t_p.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_p.ForeColor = System.Drawing.Color.White
        Me.t_p.Location = New System.Drawing.Point(281, 60)
        Me.t_p.Name = "t_p"
        Me.t_p.Size = New System.Drawing.Size(30, 40)
        Me.t_p.TabIndex = 31
        Me.t_p.Text = "P"
        '
        't_g
        '
        Me.t_g.BackColor = System.Drawing.Color.Navy
        Me.t_g.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_g.ForeColor = System.Drawing.Color.White
        Me.t_g.Location = New System.Drawing.Point(131, 100)
        Me.t_g.Name = "t_g"
        Me.t_g.Size = New System.Drawing.Size(30, 40)
        Me.t_g.TabIndex = 36
        Me.t_g.Text = "G"
        '
        't_f
        '
        Me.t_f.BackColor = System.Drawing.Color.Navy
        Me.t_f.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_f.ForeColor = System.Drawing.Color.White
        Me.t_f.Location = New System.Drawing.Point(101, 100)
        Me.t_f.Name = "t_f"
        Me.t_f.Size = New System.Drawing.Size(30, 40)
        Me.t_f.TabIndex = 35
        Me.t_f.Text = "F"
        '
        't_h
        '
        Me.t_h.BackColor = System.Drawing.Color.Navy
        Me.t_h.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_h.ForeColor = System.Drawing.Color.White
        Me.t_h.Location = New System.Drawing.Point(161, 100)
        Me.t_h.Name = "t_h"
        Me.t_h.Size = New System.Drawing.Size(30, 40)
        Me.t_h.TabIndex = 37
        Me.t_h.Text = "H"
        '
        't_d
        '
        Me.t_d.BackColor = System.Drawing.Color.Navy
        Me.t_d.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_d.ForeColor = System.Drawing.Color.White
        Me.t_d.Location = New System.Drawing.Point(71, 100)
        Me.t_d.Name = "t_d"
        Me.t_d.Size = New System.Drawing.Size(30, 40)
        Me.t_d.TabIndex = 34
        Me.t_d.Text = "D"
        '
        't_j
        '
        Me.t_j.BackColor = System.Drawing.Color.Navy
        Me.t_j.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_j.ForeColor = System.Drawing.Color.White
        Me.t_j.Location = New System.Drawing.Point(191, 100)
        Me.t_j.Name = "t_j"
        Me.t_j.Size = New System.Drawing.Size(30, 40)
        Me.t_j.TabIndex = 38
        Me.t_j.Text = "J"
        '
        't_s
        '
        Me.t_s.BackColor = System.Drawing.Color.Navy
        Me.t_s.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_s.ForeColor = System.Drawing.Color.White
        Me.t_s.Location = New System.Drawing.Point(41, 100)
        Me.t_s.Name = "t_s"
        Me.t_s.Size = New System.Drawing.Size(30, 40)
        Me.t_s.TabIndex = 33
        Me.t_s.Text = "S"
        '
        't_k
        '
        Me.t_k.BackColor = System.Drawing.Color.Navy
        Me.t_k.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_k.ForeColor = System.Drawing.Color.White
        Me.t_k.Location = New System.Drawing.Point(221, 100)
        Me.t_k.Name = "t_k"
        Me.t_k.Size = New System.Drawing.Size(30, 40)
        Me.t_k.TabIndex = 39
        Me.t_k.Text = "K"
        '
        't_a
        '
        Me.t_a.BackColor = System.Drawing.Color.Navy
        Me.t_a.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_a.ForeColor = System.Drawing.Color.White
        Me.t_a.Location = New System.Drawing.Point(11, 100)
        Me.t_a.Name = "t_a"
        Me.t_a.Size = New System.Drawing.Size(30, 40)
        Me.t_a.TabIndex = 32
        Me.t_a.Text = "A"
        '
        't_l
        '
        Me.t_l.BackColor = System.Drawing.Color.Navy
        Me.t_l.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_l.ForeColor = System.Drawing.Color.White
        Me.t_l.Location = New System.Drawing.Point(251, 100)
        Me.t_l.Name = "t_l"
        Me.t_l.Size = New System.Drawing.Size(30, 40)
        Me.t_l.TabIndex = 40
        Me.t_l.Text = "L"
        '
        't_ced
        '
        Me.t_ced.BackColor = System.Drawing.Color.Navy
        Me.t_ced.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_ced.ForeColor = System.Drawing.Color.White
        Me.t_ced.Location = New System.Drawing.Point(281, 100)
        Me.t_ced.Name = "t_ced"
        Me.t_ced.Size = New System.Drawing.Size(30, 40)
        Me.t_ced.TabIndex = 41
        Me.t_ced.Text = "Ç"
        '
        't_b
        '
        Me.t_b.BackColor = System.Drawing.Color.Navy
        Me.t_b.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_b.ForeColor = System.Drawing.Color.White
        Me.t_b.Location = New System.Drawing.Point(130, 140)
        Me.t_b.Name = "t_b"
        Me.t_b.Size = New System.Drawing.Size(30, 40)
        Me.t_b.TabIndex = 46
        Me.t_b.Text = "B"
        '
        't_v
        '
        Me.t_v.BackColor = System.Drawing.Color.Navy
        Me.t_v.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_v.ForeColor = System.Drawing.Color.White
        Me.t_v.Location = New System.Drawing.Point(100, 140)
        Me.t_v.Name = "t_v"
        Me.t_v.Size = New System.Drawing.Size(30, 40)
        Me.t_v.TabIndex = 45
        Me.t_v.Text = "V"
        '
        't_n
        '
        Me.t_n.BackColor = System.Drawing.Color.Navy
        Me.t_n.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_n.ForeColor = System.Drawing.Color.White
        Me.t_n.Location = New System.Drawing.Point(160, 140)
        Me.t_n.Name = "t_n"
        Me.t_n.Size = New System.Drawing.Size(30, 40)
        Me.t_n.TabIndex = 47
        Me.t_n.Text = "N"
        '
        't_c
        '
        Me.t_c.BackColor = System.Drawing.Color.Navy
        Me.t_c.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_c.ForeColor = System.Drawing.Color.White
        Me.t_c.Location = New System.Drawing.Point(70, 140)
        Me.t_c.Name = "t_c"
        Me.t_c.Size = New System.Drawing.Size(30, 40)
        Me.t_c.TabIndex = 44
        Me.t_c.Text = "C"
        '
        't_m
        '
        Me.t_m.BackColor = System.Drawing.Color.Navy
        Me.t_m.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_m.ForeColor = System.Drawing.Color.White
        Me.t_m.Location = New System.Drawing.Point(190, 140)
        Me.t_m.Name = "t_m"
        Me.t_m.Size = New System.Drawing.Size(30, 40)
        Me.t_m.TabIndex = 48
        Me.t_m.Text = "M"
        '
        't_x
        '
        Me.t_x.BackColor = System.Drawing.Color.Navy
        Me.t_x.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_x.ForeColor = System.Drawing.Color.White
        Me.t_x.Location = New System.Drawing.Point(40, 140)
        Me.t_x.Name = "t_x"
        Me.t_x.Size = New System.Drawing.Size(30, 40)
        Me.t_x.TabIndex = 43
        Me.t_x.Text = "X"
        '
        't_ponto
        '
        Me.t_ponto.BackColor = System.Drawing.Color.Navy
        Me.t_ponto.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_ponto.ForeColor = System.Drawing.Color.White
        Me.t_ponto.Location = New System.Drawing.Point(220, 140)
        Me.t_ponto.Name = "t_ponto"
        Me.t_ponto.Size = New System.Drawing.Size(30, 40)
        Me.t_ponto.TabIndex = 49
        Me.t_ponto.Text = "."
        '
        't_z
        '
        Me.t_z.BackColor = System.Drawing.Color.Navy
        Me.t_z.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_z.ForeColor = System.Drawing.Color.White
        Me.t_z.Location = New System.Drawing.Point(10, 140)
        Me.t_z.Name = "t_z"
        Me.t_z.Size = New System.Drawing.Size(30, 40)
        Me.t_z.TabIndex = 42
        Me.t_z.Text = "Z"
        '
        't_virg
        '
        Me.t_virg.BackColor = System.Drawing.Color.Navy
        Me.t_virg.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_virg.ForeColor = System.Drawing.Color.White
        Me.t_virg.Location = New System.Drawing.Point(250, 140)
        Me.t_virg.Name = "t_virg"
        Me.t_virg.Size = New System.Drawing.Size(30, 40)
        Me.t_virg.TabIndex = 50
        Me.t_virg.Text = ","
        '
        't_barra
        '
        Me.t_barra.BackColor = System.Drawing.Color.Navy
        Me.t_barra.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_barra.ForeColor = System.Drawing.Color.White
        Me.t_barra.Location = New System.Drawing.Point(280, 140)
        Me.t_barra.Name = "t_barra"
        Me.t_barra.Size = New System.Drawing.Size(30, 40)
        Me.t_barra.TabIndex = 51
        Me.t_barra.Text = "/"
        '
        't_8
        '
        Me.t_8.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_8.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_8.ForeColor = System.Drawing.Color.White
        Me.t_8.Location = New System.Drawing.Point(250, 221)
        Me.t_8.Name = "t_8"
        Me.t_8.Size = New System.Drawing.Size(30, 40)
        Me.t_8.TabIndex = 52
        Me.t_8.Text = "8"
        '
        't_9
        '
        Me.t_9.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_9.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_9.ForeColor = System.Drawing.Color.White
        Me.t_9.Location = New System.Drawing.Point(280, 221)
        Me.t_9.Name = "t_9"
        Me.t_9.Size = New System.Drawing.Size(30, 40)
        Me.t_9.TabIndex = 53
        Me.t_9.Text = "9"
        '
        't_7
        '
        Me.t_7.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_7.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_7.ForeColor = System.Drawing.Color.White
        Me.t_7.Location = New System.Drawing.Point(220, 221)
        Me.t_7.Name = "t_7"
        Me.t_7.Size = New System.Drawing.Size(30, 40)
        Me.t_7.TabIndex = 54
        Me.t_7.Text = "7"
        '
        't_esp
        '
        Me.t_esp.BackColor = System.Drawing.Color.Navy
        Me.t_esp.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.t_esp.ForeColor = System.Drawing.Color.White
        Me.t_esp.Location = New System.Drawing.Point(11, 179)
        Me.t_esp.Name = "t_esp"
        Me.t_esp.Size = New System.Drawing.Size(60, 40)
        Me.t_esp.TabIndex = 62
        Me.t_esp.Text = " Espaço"
        '
        't_5
        '
        Me.t_5.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_5.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_5.ForeColor = System.Drawing.Color.White
        Me.t_5.Location = New System.Drawing.Point(160, 221)
        Me.t_5.Name = "t_5"
        Me.t_5.Size = New System.Drawing.Size(30, 40)
        Me.t_5.TabIndex = 55
        Me.t_5.Text = "5"
        '
        't_6
        '
        Me.t_6.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_6.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_6.ForeColor = System.Drawing.Color.White
        Me.t_6.Location = New System.Drawing.Point(190, 221)
        Me.t_6.Name = "t_6"
        Me.t_6.Size = New System.Drawing.Size(30, 40)
        Me.t_6.TabIndex = 56
        Me.t_6.Text = "6"
        '
        't_back
        '
        Me.t_back.BackColor = System.Drawing.Color.Red
        Me.t_back.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_back.ForeColor = System.Drawing.Color.White
        Me.t_back.Location = New System.Drawing.Point(100, 179)
        Me.t_back.Name = "t_back"
        Me.t_back.Size = New System.Drawing.Size(30, 40)
        Me.t_back.TabIndex = 63
        Me.t_back.Text = "<"
        '
        't_4
        '
        Me.t_4.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_4.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_4.ForeColor = System.Drawing.Color.White
        Me.t_4.Location = New System.Drawing.Point(130, 221)
        Me.t_4.Name = "t_4"
        Me.t_4.Size = New System.Drawing.Size(30, 40)
        Me.t_4.TabIndex = 57
        Me.t_4.Text = "4"
        '
        't_2
        '
        Me.t_2.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_2.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_2.ForeColor = System.Drawing.Color.White
        Me.t_2.Location = New System.Drawing.Point(70, 221)
        Me.t_2.Name = "t_2"
        Me.t_2.Size = New System.Drawing.Size(30, 40)
        Me.t_2.TabIndex = 58
        Me.t_2.Text = "2"
        '
        't_ag
        '
        Me.t_ag.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.t_ag.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_ag.ForeColor = System.Drawing.Color.White
        Me.t_ag.Location = New System.Drawing.Point(130, 179)
        Me.t_ag.Name = "t_ag"
        Me.t_ag.Size = New System.Drawing.Size(30, 40)
        Me.t_ag.TabIndex = 64
        Me.t_ag.Text = "´"
        '
        't_3
        '
        Me.t_3.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_3.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_3.ForeColor = System.Drawing.Color.White
        Me.t_3.Location = New System.Drawing.Point(100, 221)
        Me.t_3.Name = "t_3"
        Me.t_3.Size = New System.Drawing.Size(30, 40)
        Me.t_3.TabIndex = 59
        Me.t_3.Text = "3"
        '
        't_1
        '
        Me.t_1.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_1.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_1.ForeColor = System.Drawing.Color.White
        Me.t_1.Location = New System.Drawing.Point(40, 221)
        Me.t_1.Name = "t_1"
        Me.t_1.Size = New System.Drawing.Size(30, 40)
        Me.t_1.TabIndex = 60
        Me.t_1.Text = "1"
        '
        't_tio
        '
        Me.t_tio.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.t_tio.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_tio.ForeColor = System.Drawing.Color.White
        Me.t_tio.Location = New System.Drawing.Point(160, 179)
        Me.t_tio.Name = "t_tio"
        Me.t_tio.Size = New System.Drawing.Size(30, 40)
        Me.t_tio.TabIndex = 64
        Me.t_tio.Text = "~"
        '
        't_0
        '
        Me.t_0.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_0.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_0.ForeColor = System.Drawing.Color.White
        Me.t_0.Location = New System.Drawing.Point(10, 221)
        Me.t_0.Name = "t_0"
        Me.t_0.Size = New System.Drawing.Size(30, 40)
        Me.t_0.TabIndex = 61
        Me.t_0.Text = "0"
        '
        't_circ
        '
        Me.t_circ.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.t_circ.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_circ.ForeColor = System.Drawing.Color.White
        Me.t_circ.Location = New System.Drawing.Point(190, 179)
        Me.t_circ.Name = "t_circ"
        Me.t_circ.Size = New System.Drawing.Size(30, 40)
        Me.t_circ.TabIndex = 64
        Me.t_circ.Text = "^"
        '
        't_tra
        '
        Me.t_tra.BackColor = System.Drawing.Color.Navy
        Me.t_tra.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_tra.ForeColor = System.Drawing.Color.White
        Me.t_tra.Location = New System.Drawing.Point(280, 179)
        Me.t_tra.Name = "t_tra"
        Me.t_tra.Size = New System.Drawing.Size(30, 40)
        Me.t_tra.TabIndex = 65
        Me.t_tra.Text = "-"
        '
        't_enter
        '
        Me.t_enter.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.t_enter.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_enter.ForeColor = System.Drawing.Color.White
        Me.t_enter.Location = New System.Drawing.Point(245, 27)
        Me.t_enter.Name = "t_enter"
        Me.t_enter.Size = New System.Drawing.Size(65, 32)
        Me.t_enter.TabIndex = 66
        Me.t_enter.Text = "Enter"
        '
        'dispray
        '
        Me.dispray.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.dispray.Location = New System.Drawing.Point(10, 2)
        Me.dispray.Name = "dispray"
        Me.dispray.Size = New System.Drawing.Size(300, 26)
        Me.dispray.TabIndex = 67
        '
        'Button48
        '
        Me.Button48.BackColor = System.Drawing.Color.Red
        Me.Button48.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button48.ForeColor = System.Drawing.Color.White
        Me.Button48.Location = New System.Drawing.Point(12, 27)
        Me.Button48.Name = "Button48"
        Me.Button48.Size = New System.Drawing.Size(50, 32)
        Me.Button48.TabIndex = 68
        Me.Button48.Text = "X"
        '
        'Button49
        '
        Me.Button49.BackColor = System.Drawing.Color.Yellow
        Me.Button49.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button49.ForeColor = System.Drawing.Color.Black
        Me.Button49.Location = New System.Drawing.Point(68, 27)
        Me.Button49.Name = "Button49"
        Me.Button49.Size = New System.Drawing.Size(50, 32)
        Me.Button49.TabIndex = 69
        Me.Button49.Text = "[ ]"
        '
        'tecrado
        '
        Me.tecrado.Controls.Add(Me.t_asc)
        Me.tecrado.Controls.Add(Me.t_mais)
        Me.tecrado.Controls.Add(Me.dispray)
        Me.tecrado.Controls.Add(Me.Button49)
        Me.tecrado.Controls.Add(Me.t_tra)
        Me.tecrado.Controls.Add(Me.t_circ)
        Me.tecrado.Controls.Add(Me.t_enter)
        Me.tecrado.Controls.Add(Me.Button48)
        Me.tecrado.Controls.Add(Me.t_0)
        Me.tecrado.Controls.Add(Me.t_tio)
        Me.tecrado.Controls.Add(Me.t_1)
        Me.tecrado.Controls.Add(Me.t_3)
        Me.tecrado.Controls.Add(Me.t_ag)
        Me.tecrado.Controls.Add(Me.t_4)
        Me.tecrado.Controls.Add(Me.t_q)
        Me.tecrado.Controls.Add(Me.t_a)
        Me.tecrado.Controls.Add(Me.t_t)
        Me.tecrado.Controls.Add(Me.t_2)
        Me.tecrado.Controls.Add(Me.t_m)
        Me.tecrado.Controls.Add(Me.t_r)
        Me.tecrado.Controls.Add(Me.t_g)
        Me.tecrado.Controls.Add(Me.t_5)
        Me.tecrado.Controls.Add(Me.T_Y)
        Me.tecrado.Controls.Add(Me.t_6)
        Me.tecrado.Controls.Add(Me.t_back)
        Me.tecrado.Controls.Add(Me.t_7)
        Me.tecrado.Controls.Add(Me.t_e)
        Me.tecrado.Controls.Add(Me.t_8)
        Me.tecrado.Controls.Add(Me.t_f)
        Me.tecrado.Controls.Add(Me.t_9)
        Me.tecrado.Controls.Add(Me.t_u)
        Me.tecrado.Controls.Add(Me.t_b)
        Me.tecrado.Controls.Add(Me.t_w)
        Me.tecrado.Controls.Add(Me.t_h)
        Me.tecrado.Controls.Add(Me.t_i)
        Me.tecrado.Controls.Add(Me.t_o)
        Me.tecrado.Controls.Add(Me.t_d)
        Me.tecrado.Controls.Add(Me.t_p)
        Me.tecrado.Controls.Add(Me.t_n)
        Me.tecrado.Controls.Add(Me.t_j)
        Me.tecrado.Controls.Add(Me.t_s)
        Me.tecrado.Controls.Add(Me.t_ponto)
        Me.tecrado.Controls.Add(Me.t_k)
        Me.tecrado.Controls.Add(Me.t_esp)
        Me.tecrado.Controls.Add(Me.t_l)
        Me.tecrado.Controls.Add(Me.t_ced)
        Me.tecrado.Controls.Add(Me.t_virg)
        Me.tecrado.Controls.Add(Me.t_barra)
        Me.tecrado.Controls.Add(Me.t_z)
        Me.tecrado.Controls.Add(Me.t_v)
        Me.tecrado.Controls.Add(Me.t_x)
        Me.tecrado.Controls.Add(Me.t_c)
        Me.tecrado.Location = New System.Drawing.Point(756, 140)
        Me.tecrado.Name = "tecrado"
        Me.tecrado.Size = New System.Drawing.Size(320, 280)
        Me.tecrado.Visible = False
        '
        't_asc
        '
        Me.t_asc.BackColor = System.Drawing.Color.Navy
        Me.t_asc.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_asc.ForeColor = System.Drawing.Color.White
        Me.t_asc.Location = New System.Drawing.Point(220, 179)
        Me.t_asc.Name = "t_asc"
        Me.t_asc.Size = New System.Drawing.Size(30, 40)
        Me.t_asc.TabIndex = 69
        Me.t_asc.Text = "*"
        '
        't_mais
        '
        Me.t_mais.BackColor = System.Drawing.Color.Navy
        Me.t_mais.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.t_mais.ForeColor = System.Drawing.Color.White
        Me.t_mais.Location = New System.Drawing.Point(250, 179)
        Me.t_mais.Name = "t_mais"
        Me.t_mais.Size = New System.Drawing.Size(30, 40)
        Me.t_mais.TabIndex = 68
        Me.t_mais.Text = "+"
        '
        'Button11
        '
        Me.Button11.BackColor = System.Drawing.Color.LightSkyBlue
        Me.Button11.Font = New System.Drawing.Font("Tahoma", 12.0!, System.Drawing.FontStyle.Bold)
        Me.Button11.ForeColor = System.Drawing.Color.Black
        Me.Button11.Location = New System.Drawing.Point(0, 0)
        Me.Button11.Name = "Button11"
        Me.Button11.Size = New System.Drawing.Size(30, 20)
        Me.Button11.TabIndex = 23
        Me.Button11.Text = "t"
        '
        'b_resposta
        '
        Me.b_resposta.Location = New System.Drawing.Point(0, 101)
        Me.b_resposta.Name = "b_resposta"
        Me.b_resposta.Size = New System.Drawing.Size(312, 114)
        Me.b_resposta.TabIndex = 24
        '
        'c_resposta
        '
        Me.c_resposta.Location = New System.Drawing.Point(71, 72)
        Me.c_resposta.Name = "c_resposta"
        Me.c_resposta.Size = New System.Drawing.Size(119, 23)
        Me.c_resposta.TabIndex = 25
        Me.c_resposta.Visible = False
        '
        'Panel2
        '
        Me.Panel2.Controls.Add(Me.b_letra)
        Me.Panel2.Controls.Add(Me.Button13)
        Me.Panel2.Controls.Add(Me.Button12)
        Me.Panel2.Location = New System.Drawing.Point(200, 72)
        Me.Panel2.Name = "Panel2"
        Me.Panel2.Size = New System.Drawing.Size(112, 26)
        Me.Panel2.Visible = False
        '
        'b_letra
        '
        Me.b_letra.BackColor = System.Drawing.Color.Yellow
        Me.b_letra.Font = New System.Drawing.Font("Tahoma", 10.0!, System.Drawing.FontStyle.Bold)
        Me.b_letra.ForeColor = System.Drawing.Color.Black
        Me.b_letra.Location = New System.Drawing.Point(37, 0)
        Me.b_letra.Name = "b_letra"
        Me.b_letra.Size = New System.Drawing.Size(37, 26)
        Me.b_letra.TabIndex = 33
        Me.b_letra.Text = "A"
        '
        'Button13
        '
        Me.Button13.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Button13.Font = New System.Drawing.Font("Wingdings", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button13.ForeColor = System.Drawing.Color.White
        Me.Button13.Location = New System.Drawing.Point(0, 0)
        Me.Button13.Name = "Button13"
        Me.Button13.Size = New System.Drawing.Size(36, 26)
        Me.Button13.TabIndex = 34
        Me.Button13.Text = "ç"
        '
        'Button12
        '
        Me.Button12.BackColor = System.Drawing.Color.FromArgb(CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(192, Byte), Integer))
        Me.Button12.Font = New System.Drawing.Font("Wingdings", 10.0!, System.Drawing.FontStyle.Bold)
        Me.Button12.ForeColor = System.Drawing.Color.White
        Me.Button12.Location = New System.Drawing.Point(74, 0)
        Me.Button12.Name = "Button12"
        Me.Button12.Size = New System.Drawing.Size(36, 26)
        Me.Button12.TabIndex = 33
        Me.Button12.Text = "è"
        '
        'l_p
        '
        Me.l_p.BackColor = System.Drawing.Color.Black
        Me.l_p.ForeColor = System.Drawing.Color.White
        Me.l_p.Location = New System.Drawing.Point(3, 74)
        Me.l_p.Name = "l_p"
        Me.l_p.Size = New System.Drawing.Size(62, 20)
        Me.l_p.Text = "Estado"
        Me.l_p.Visible = False
        '
        'aplic
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(96.0!, 96.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
        Me.AutoScroll = True
        Me.BackColor = System.Drawing.Color.Black
        Me.ClientSize = New System.Drawing.Size(1421, 515)
        Me.Controls.Add(Me.l_p)
        Me.Controls.Add(Me.Panel2)
        Me.Controls.Add(Me.c_resposta)
        Me.Controls.Add(Me.b_resposta)
        Me.Controls.Add(Me.tecrado)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.Button7)
        Me.Controls.Add(Me.Button6)
        Me.Controls.Add(Me.Button5)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.l_resposta)
        Me.Controls.Add(Me.l_tipo)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.t_resposta)
        Me.Controls.Add(Me.l_pergunta)
        Me.Controls.Add(Me.Button50)
        Me.Controls.Add(Me.Button11)
        Me.Name = "aplic"
        Me.Text = "Pesquisa"
        Me.Panel1.ResumeLayout(False)
        Me.tecrado.ResumeLayout(False)
        Me.Panel2.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents l_pergunta As System.Windows.Forms.Label
    Friend WithEvents t_resposta As System.Windows.Forms.TextBox
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents l_tipo As System.Windows.Forms.Label
    Friend WithEvents l_resposta As System.Windows.Forms.Panel
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Button5 As System.Windows.Forms.Button
    Friend WithEvents Button6 As System.Windows.Forms.Button
    Friend WithEvents Button7 As System.Windows.Forms.Button
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents Button10 As System.Windows.Forms.Button
    Friend WithEvents Button9 As System.Windows.Forms.Button
    Friend WithEvents Button8 As System.Windows.Forms.Button
    Friend WithEvents DataGrid1 As System.Windows.Forms.DataGrid
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button50 As System.Windows.Forms.Button
    Friend WithEvents t_t As System.Windows.Forms.Button
    Friend WithEvents t_r As System.Windows.Forms.Button
    Friend WithEvents T_Y As System.Windows.Forms.Button
    Friend WithEvents t_e As System.Windows.Forms.Button
    Friend WithEvents t_u As System.Windows.Forms.Button
    Friend WithEvents t_w As System.Windows.Forms.Button
    Friend WithEvents t_i As System.Windows.Forms.Button
    Friend WithEvents t_q As System.Windows.Forms.Button
    Friend WithEvents t_o As System.Windows.Forms.Button
    Friend WithEvents t_p As System.Windows.Forms.Button
    Friend WithEvents t_g As System.Windows.Forms.Button
    Friend WithEvents t_f As System.Windows.Forms.Button
    Friend WithEvents t_h As System.Windows.Forms.Button
    Friend WithEvents t_d As System.Windows.Forms.Button
    Friend WithEvents t_j As System.Windows.Forms.Button
    Friend WithEvents t_s As System.Windows.Forms.Button
    Friend WithEvents t_k As System.Windows.Forms.Button
    Friend WithEvents t_a As System.Windows.Forms.Button
    Friend WithEvents t_l As System.Windows.Forms.Button
    Friend WithEvents t_ced As System.Windows.Forms.Button
    Friend WithEvents t_b As System.Windows.Forms.Button
    Friend WithEvents t_v As System.Windows.Forms.Button
    Friend WithEvents t_n As System.Windows.Forms.Button
    Friend WithEvents t_c As System.Windows.Forms.Button
    Friend WithEvents t_m As System.Windows.Forms.Button
    Friend WithEvents t_x As System.Windows.Forms.Button
    Friend WithEvents t_ponto As System.Windows.Forms.Button
    Friend WithEvents t_z As System.Windows.Forms.Button
    Friend WithEvents t_virg As System.Windows.Forms.Button
    Friend WithEvents t_barra As System.Windows.Forms.Button
    Friend WithEvents t_8 As System.Windows.Forms.Button
    Friend WithEvents t_9 As System.Windows.Forms.Button
    Friend WithEvents t_7 As System.Windows.Forms.Button
    Friend WithEvents t_esp As System.Windows.Forms.Button
    Friend WithEvents t_5 As System.Windows.Forms.Button
    Friend WithEvents t_6 As System.Windows.Forms.Button
    Friend WithEvents t_back As System.Windows.Forms.Button
    Friend WithEvents t_4 As System.Windows.Forms.Button
    Friend WithEvents t_2 As System.Windows.Forms.Button
    Friend WithEvents t_ag As System.Windows.Forms.Button
    Friend WithEvents t_3 As System.Windows.Forms.Button
    Friend WithEvents t_1 As System.Windows.Forms.Button
    Friend WithEvents t_tio As System.Windows.Forms.Button
    Friend WithEvents t_0 As System.Windows.Forms.Button
    Friend WithEvents t_circ As System.Windows.Forms.Button
    Friend WithEvents t_tra As System.Windows.Forms.Button
    Friend WithEvents t_enter As System.Windows.Forms.Button
    Friend WithEvents dispray As System.Windows.Forms.TextBox
    Friend WithEvents Button48 As System.Windows.Forms.Button
    Friend WithEvents Button49 As System.Windows.Forms.Button
    Friend WithEvents tecrado As System.Windows.Forms.Panel
    Friend WithEvents t_asc As System.Windows.Forms.Button
    Friend WithEvents t_mais As System.Windows.Forms.Button
    Friend WithEvents Button11 As System.Windows.Forms.Button
    Friend WithEvents b_resposta As System.Windows.Forms.ListBox
    Friend WithEvents c_resposta As System.Windows.Forms.ComboBox
    Friend WithEvents Panel2 As System.Windows.Forms.Panel
    Friend WithEvents b_letra As System.Windows.Forms.Button
    Friend WithEvents Button13 As System.Windows.Forms.Button
    Friend WithEvents Button12 As System.Windows.Forms.Button
    Friend WithEvents l_p As System.Windows.Forms.Label
End Class
