#!/usr/bin/python


import collections
import json
import csv
import re

import os
import sys

from Bio import SeqIO
from Bio import Seq
from Bio.Seq import Seq
from subprocess import Popen, PIPE

from bandwagon import BandsPattern, BandsPatternsSet, custom_ladder, LADDER_100_to_4k

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')

makeblastdb = '/usr/bin/makeblastdb';
#makeblastdb = '/usr/local/ncbi/blast/bin/makeblastdb';
blastn = '/usr/local/bin/blastn'
#blastn = '/usr/local/ncbi/blast/bin/blastn'
cutadapt = '/usr/local/bin/cutadapt'

# CpnClassiPhyR - Classification of Phytoplasma Cpn60 sequences using insilico RFLP analysis
class CpnClassiPhyR():

    
    def __init__(self):
        
        #print("Initializing CpnClassiPhyR.....")
        
        # Restriction enzymes and restriction site sequences used in the insilico RFLP digests.
        self.renzymes = {
            'AluI': r'(AG)(CT)', # 'AluI': 'AG^CT', # pos 2
            'BfaI': r'(C)(TAG)', # 'BfaI': 'C^TAG', # pos 1
            # 'DraI': r'(TTT)(AAA)', # DraI: 'TTT^AAA', # pos 3
#            'Bce3081I': r'(T)(AGGAG)', # 'Bce3081I': 'T^AGGAG', # pos 1
#            'Cje263IV': r'([ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG]G)(AGTTTTGGT[ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG])', # 'Cje263IV': 'G^AGTTTTGGT', # pos 1
            'HinfI': r'(G)(A[ATCG]TC)', # 'HinfI': 'G^ANTC', # pos 1
            'HpaI': r'(GTT)(AAC)', # 'HpaI': 'GTT^AAC', # pos 3
            'MseI': r'(T)(TAA)', # 'MseI': 'T^TAA', # pos 1
            'RsaI': r'(GT)(AC)', # 'RsaI': 'GT^AC', # pos 2
            'TaqI': r'(T)(CGA)', # 'TaqI': 'T^CGA', # pos 1
            
#            # New Enzymes to add.
#            'BamHI': r'(G)(GATCC)', # 'BamHI': 'G^GATCC', # pos 1
#            'BstUI': r'(CG)(CG)', # 'BstUI': 'CG^CG', # pos 2
#            'DraI': r'(TTT)(AAA)', # 'DraI': 'TTT^AAAA', # pos 3
#            'EcoRI': r'(G)(AATTC)', # 'EcoRI': 'G^AATTC', # pos 1
#            'HaeIII': r'(GG)(CC)', # 'HaeIII': 'GG^CC', # pos 2
#            'HhaI': r'(GCG)(C)', # 'HhaI': 'GCG^C', # pos 3
#            'HpaII': r'(C)(CGG)', # 'HpaII': 'C^CGG', # pos 1
#            'KpnI': r'(GGTAC)(C)', # 'KpnI': 'GGTAC^C', # pos 5
#            'Sau3AI': r'(N)GATC(N)', # 'Sau3AI': '^GATC', # pos 0
#            'SspI': r'(AAT)(ATT)' # 'SspI': 'AAT^ATT', # pos 3

        }

#    def rsites(self):
#        rsites = {}
#        for renzyme in sorted(self.renzymes):
#            temp = self.renzymes[renzyme].replace(")(", "^").replace(")","").replace("(", "")
#            
#            print(temp)



    def makeblastdb_nuc(self, target_infile):

        fastadbNIN = target_infile + '.nin'
        fastadbNSQ = target_infile + '.nsq'
        fastadbNHR = target_infile + '.nhr'
        if(not(os.path.exists(fastadbNIN) or (os.path.getsize(fastadbNIN) == 0))
           and not(os.path.exists(fastadbNSQ) or (os.path.getsize(fastadbNSQ) == 0))
           and not(os.path.exists(fastadbNHR) or (os.path.getsize(fastadbNHR) == 0))):
            #warn "Calling makeblastdb for fastadb....\n";
            #warn "makeblastdb -in fastadb -dbtype nucl\n\n";
            os.system(makeblastdb +  ' ' + '-in' + ' ' + target_infile + ' ' + '-dbtype' + ' ' + 'nucl')


    def CpnIdentiPhyR(self, query_infile, target_infile, output_dir):
        self.makeblastdb_nuc(target_infile)

        clean_up_metadata = {}
        file_count = 1
        processed_filepaths = []
        for fasta_record in SeqIO.parse(query_infile, "fasta"):
            
            qseqid = str(fasta_record.id)
            qseq = str(fasta_record.seq).upper()
            desc = " ".join(fasta_record.description.split()[1:])
            qalltitles = str("_".join([qseqid, str(file_count)])) + " " + desc
            #NEED TO MAKE THIS LINE MORE ROBUST BY SAVING THE FILE AND USING IT AS THE QUERY INPUT FOR LONGER SEQUENCES
            blastn_cmd = " ".join([blastn, "-query", '<(echo -e \">{}\\n{}\")'.format(qalltitles, qseq), "-db", target_infile, "-task", "blastn", "-dust", "yes", "-max_target_seqs", "50", "-evalue", "1e-6", "-outfmt", "'6 qseqid salltitles qcovhsp pident length mismatch gapopen qstart qend sstart send sstrand evalue bitscore'"])
            print(blastn_cmd)
            p = Popen(blastn_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
            (blast_results, err) = p.communicate()
            p_status = p.wait()
            
            blast_output = blast_results.decode("utf-8")
            print(blast_output)
            print(err.decode("utf-8"))
            print(p_status)
            
            if(p_status == 0):
                is_phytoplasma = "false"
                best_hit = None
                blast_hit_list = blast_output.splitlines()
                for line in blast_hit_list:
                    blast_hit = line.rstrip()
                    blast_fields = blast_hit.split('\t')
                    target_name = blast_fields[1]
                    #        print(target_name)
                    if(re.search('Phytoplasma', target_name)):
                        best_hit = blast_fields
                        align_length = int(best_hit[4])
                        percent_identity = float(best_hit[3])
                        #                print(align_length)
                        #                sys.exit()
                        if(((align_length >= 530) and (align_length <= 560)) and (percent_identity >= 70)):
                            is_phytoplasma = "true"
                            break
                    else:
                        best_hit = blast_fields
                        break


                if(is_phytoplasma == "true"):
                    #        print(best_hit)
                    target_strand = best_hit[11]
                    #        print(target_strand)
                    blastn_outfile = os.path.join(output_dir, "_".join([qseqid, str(file_count), "trimmed-sense.fasta"]))
                    processed_filepaths.append(blastn_outfile)
                    if(target_strand == "plus"):
                        print(target_strand)
                        
                        cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNACN", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNACN", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseq), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCAN", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCAN", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", blastn_outfile])
                        print(cutadapt_cmd)
                        p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                        (cutadapt_results, err) = p.communicate()
                        p_status = p.wait()
                        
                        cutadapt_output = cutadapt_results.decode("utf-8")
                        print(cutadapt_output)
                        print(err.decode("utf-8"))
                        print(p_status)
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles] + best_hit + ['Phytoplasma sequence (+ strand)']
                    elif(target_strand == "minus"):
                        #                print(target_strand)
                        
                        qseqrc = Seq(qseq).reverse_complement()
                        cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNACN", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNACN", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseqrc), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCAN", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCAN", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", blastn_outfile])
                        print(cutadapt_cmd)
                        p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                        (cutadapt_results, err) = p.communicate()
                        p_status = p.wait()
                        
                        cutadapt_output = cutadapt_results.decode("utf-8")
                        print(cutadapt_output)
                        print(err.decode("utf-8"))
                        print(p_status)
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles] + best_hit + ['Phytoplasma sequence (- strand)']

                elif(is_phytoplasma == "false"):
                    print("Not a phytoplasma sequence")
                    print(blast_hit_list)
                    if(best_hit == None):
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles, 'N/A', 'No Phytoplasma sequence matches', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Not a Phytoplasma sequence']
                    else:
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles] + best_hit + ['Not a Phytoplasma sequence']


            else:
                print(" ".join(["Error:", err.decode("utf-8"), "Process status:", str(p_status), "Command:"," ".join(blastn_cmd)]))
                sys.exit(1)
            file_count = file_count + 1

        print(clean_up_metadata)

        clean_up_metadata_outfile = os.path.join(output_dir, 'clean_up_metadata.csv')

        f = open(clean_up_metadata_outfile, 'w')
        output_file = csv.writer(f)
        output_file.writerow(["Sequence ID", "Description",	"Query ID","Target ID",	"Coverage", "Percent Identity", "Length", "Mismatch", "Gap Open", "Query Start", "Query End", "Target Start", "Target End", "Strandedness", "E-Value", "Bit Score", "Classification"])
        for qseqid in clean_up_metadata:
            output_file.writerow([qseqid] + clean_up_metadata[qseqid])
        f.close()

        CpnIdentiPhyR_outfile = os.path.join(output_dir, "all-trimmed-sense.fasta")
        with open(CpnIdentiPhyR_outfile, 'w') as f_out:
            for filepath in processed_filepaths:
                for fasta_record in SeqIO.parse(filepath, "fasta"):
                    r = SeqIO.write(fasta_record, f_out, 'fasta')
                    if(r != 1):
                        print('Error while writing sequence:  ' + seq_record.id)


        #subgroup_sc_matrix_infile = os.path.join('/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR','clean_up_metadata.json')
        #subgroup_sc_matrix_file = open(subgroup_sc_matrix_infile, "w+")
        #subgroup_sc_matrix_file.write(json.dumps(clean_up_metadata, indent=4))
        #subgroup_sc_matrix_file.close()
        return CpnIdentiPhyR_outfile

#cpn_phytoplasma_primers = {
#    'H279p': 'GATNNNGCAGGNGATGGAACMACNACN',
#    'D0317': 'GATNNNKCNGGNGAYGGNACNACNACN',
#    'H280p': 'AATGCNCCTGGTTTTGGNGANAAYCAN',
#    'D0318': 'GAWGCNCCWRGTTTTGGNGANMAYCAN'
#}
    def RFLP_digest(self, seq):

        seq = seq.upper()

        digest_metadata = {}
        for renzyme in sorted(self.renzymes):
            rsite_regex = self.renzymes[renzyme]
            digested_seq = re.sub(rsite_regex, r'\1 \2', seq).split(' ')
            digest_metadata[str((renzyme, 'Fragments'))] = digested_seq
            digest_metadata[str((renzyme, 'Number of Bands'))] = len(digested_seq)
            band_sizes = []
            for fragments in digested_seq:
               band_sizes.append(len(fragments))
            digest_metadata[str((renzyme, 'Band Sizes'))] = band_sizes


        return digest_metadata



    def RFLP_digests(self, fasta_infile):
        RFLP_digests = {}
        for fasta_record in SeqIO.parse(fasta_infile, "fasta"):

            id = str(fasta_record.id)
            sequence = str(fasta_record.seq)
            desc = str(fasta_record.description)
            print(sequence)
#            sys.exit()
            digest_metadata = self.RFLP_digest(sequence)
            digest_metadata['ID'] = id
            digest_metadata['Description'] = desc
            digest_metadata['Nucleotide UT Sequence'] = sequence
            digest_metadata['Nucleotide UT Sequence Length'] = len(sequence)
            
            amino_acid_sequence = Seq.translate(fasta_record.seq, table='Standard', stop_symbol='*', to_stop=False, cds=False, gap=None)
#            print(str(amino_acid_sequence))
            digest_metadata['Peptide UT Sequence'] = str(amino_acid_sequence)
            digest_metadata['Peptide UT Sequence Length'] = len(digest_metadata['Peptide UT Sequence'])
            RFLP_digests[id] = digest_metadata
        return RFLP_digests
    
    
    
#    def common_band_count(self, band_size_list1, band_size_list2):
#        
#        common_bands = 0
#        i = 0
#        while(i < len(band_size_list2)):
#            j = 0
#            while(j < len(band_size_list1)):
#                if(band_size_list2[i] == band_size_list1[j]):
#                    common_bands += 1
#                j += 1
#            i += 1
#            
#        return common_bands

    def common_band_count(self, band_size_list1, band_size_list2):

        sorted_band_size_list1 = sorted(band_size_list1)
        sorted_band_size_list2 = sorted(band_size_list2)
#        print(sorted_band_size_list1)
#        print(sorted_band_size_list2)


        band_size_list_queue = collections.deque()
        band_size_list_queue.extend(sorted_band_size_list1)
        band_size_list = sorted_band_size_list2

        common_bands = 0
        i = 0
        while(i < len(band_size_list)):
            try:
                band_size = band_size_list_queue.popleft()
            except IndexError:
                break
            
            
            if(band_size == band_size_list[i]):
                common_bands += 1
                i += 1
            

            elif(band_size < band_size_list[i]):
                continue
            elif(band_size > band_size_list[i]):
                curr = i
                while(curr < len(band_size_list)):
                    if(band_size == band_size_list[curr]):
                        common_bands += 1
                        i = curr + 1
                        break
#                    if(i < len(band_size_list)):
                    curr += 1
#                i = curr

        
                
                
        


#        print(common_bands)
        return common_bands



#    def common_band_count(self, band_size_list1, band_size_list2):
#
#        sorted_band_size_list1 = sorted(band_size_list1)
#        sorted_band_size_list2 = sorted(band_size_list2)
#        print(sorted_band_size_list1)
#        print(sorted_band_size_list2)
#        
#        
#        band_size_list_queue = collections.deque()
#        band_size_list = []
#        if(len(sorted_band_size_list2) >= len(sorted_band_size_list1)):
#            band_size_list_queue = collections.deque()
#            band_size_list_queue.extend(sorted_band_size_list1)
#            band_size_list = sorted_band_size_list2
#            print(band_size_list_queue)
#        elif(len(sorted_band_size_list2) < len(sorted_band_size_list1)):
#            band_size_list_queue.extend(sorted_band_size_list2)
#            band_size_list = sorted_band_size_list1
#            print(band_size_list_queue)
#
#        common_bands = 0
#        i = 0
#        while(True):
#            try:
#                band_size = band_size_list_queue.popleft()
#            except IndexError:
#                break
#            while(i < len(band_size_list)):
#                if(band_size == band_size_list[i]):
#                    common_bands += 1
##                    i += 1
#                    break
#    
#                i += 1
#
#        print(common_bands)
#        return common_bands
#        sys.exit()
#        common_bands = 0
#        i = 0
#        while(i < len(band_size_list2)):
#            j = 0
#            while(j < len(band_size_list1)):
#                if(band_size_list2[i] == band_size_list1[j]):
#                    common_bands += 1
#                j += 1
#            i += 1
#
#        return common_bands


    def calc_similarity_coefficient(self, RFLP_digest1, RFLP_digest2):
        similarity_coefficient = {}
#        common_bands = {}
        Nx = 0
        Ny = 0
        Nxy = 0
        for renzyme in sorted(self.renzymes):
#            print(RFLP_digest1[str((renzyme,'Band Sizes'))])
#            print(RFLP_digest2[str((renzyme,'Band Sizes'))])
#            
#            common_bands[str((renzyme,'common_bands'))] = self.common_band_count(RFLP_digest1[str((renzyme,'Band Sizes'))], RFLP_digest2[str((renzyme,'Band Sizes'))])
#            
#            print(common_bands[str((renzyme,'common_bands'))])
            Nx += RFLP_digest1[str((renzyme,'Number of Bands'))]
            Ny += RFLP_digest2[str((renzyme,'Number of Bands'))]
#            print(renzyme)
            Nxy += self.common_band_count(RFLP_digest1[str((renzyme,'Band Sizes'))], RFLP_digest2[str((renzyme,'Band Sizes'))])
        
        # F=2(Nxy)/Nx+Ny
        F = (2 * Nxy) / (Nx + Ny)
#        print(Nxy)
#        print(Nx)
#        print(Ny)
#
#        print(F)
        F_value = '{0:1.2f}'.format(F)
        
        similarity_coefficient['Nx'] = Nx
        similarity_coefficient['Ny'] = Ny
        similarity_coefficient['Nxy'] = Nxy
        similarity_coefficient['F'] = F
        similarity_coefficient['F Value'] = F_value
        
        return similarity_coefficient





    def similarity_coefficient_matrix(self, RFLP_digests):

        similarity_coefficients = {}
        for strain1 in sorted(RFLP_digests):
            for strain2 in sorted(RFLP_digests):
                
#                if(strain2 == strain1):
#                    print("strain2 == strain1")
#                    print(strain2 + " == " + strain1)
#                    # F-Value equals 1
#                    similarity_coefficients[str((strain1,strain2))] = 1.00
#                else:
#                print(strain1)
#                print(strain2)
#                print(RFLP_digests[strain1])
#                print(RFLP_digests[strain2])

                similarity_coefficient_metadata = self.calc_similarity_coefficient(RFLP_digests[strain1], RFLP_digests[strain2])
#                    similarity_coefficients[str((strain1,strain2))] = similarity_coefficient_metadata['F Value']

                similarity_coefficients[str((strain1,strain2))] = similarity_coefficient_metadata
#                print(similarity_coefficients[str((strain1,strain2))])
#        sys.exit()
        return similarity_coefficients

    def draw_gel(self,digest_metadata,xlabel,output_dir):
        strain_name = digest_metadata['ID']
        cpn60UT_ladder = custom_ladder("cpn60UT", {
                                       25: 250,
                                       50: 225,
                                       100: 205,
                                       200: 186,
                                       300: 171,
                                       400: 158,
                                       500: 149,
                                       600: 139
                                       })
        LADDER_100_to_1k  = custom_ladder("cpn60UT", {
                                          
            25: 249,
            50: 226,
            100: 205,
            200: 186,
            300: 171,
            400: 158,
            500: 149,
            650: 139,
            850: 128,
            1000: 121
        })
#        ladder = cpn60UT_ladder.modified(background_color="#E2EDFF", label_fontdict={"rotation": -90}, label="MW")
        ladder = LADDER_100_to_1k.modified(background_color="#E2EDFF", label_fontdict={"rotation": -90}, label="MW")
        patterns = []
        for renzyme in sorted(self.renzymes):
            patterns.append(BandsPattern(digest_metadata[str((renzyme, 'Band Sizes'))], ladder, label_fontdict={"rotation": -90}, label=renzyme))
        #    patterns_set = BandsPatternsSet(patterns=[ladder] + patterns, ladder=ladder, label_fontdict={"size": 7}, label="Migration Distance", ladder_ticks=3)
        patterns_set = BandsPatternsSet(patterns=[ladder] + patterns, ladder=ladder, ladder_ticks=3)
        ax = patterns_set.plot()
        ax.set_xlabel(xlabel)

        strain_filename = strain_name.replace("/", "-").replace("(", "_").replace(")", "_")
        outfile = os.path.join(output_dir, strain_filename + ".png")
        if not os.path.exists(outfile):
            ax.figure.savefig(outfile, bbox_inches="tight", dpi=600)

        return outfile



